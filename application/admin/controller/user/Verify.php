<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/27
 * Time: 10:20
 */

namespace app\admin\controller\user;

use app\common\controller\Backend;
class Verify extends Backend
{
    protected $relationSearch = true;

    /**
     * @var \app\admin\model\User
     * @var \app\admin\model\UserRealinfo
     */

    protected $model = null;
    protected $realModel = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('User');
        $this->realModel = model('UserRealinfo');
    }
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            //$sort='a.real_id';
            $total = $this->realModel
                ->alias('a')
                ->field('a.*,b.nickname')
                ->join('user b','b.id = a.user_id')
                ->where($where)
                ->where(['deleted'=>0])
                ->order($sort, $order)
                ->count();
            $list = $this->realModel
                ->alias('a')
                ->field('a.*,b.nickname')
                ->join('user b','b.id = a.user_id')
                ->where($where)
                ->where(['deleted'=>0])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 详情
     */
    public function detail($ids){

        $row = $this->realModel
            ->alias('a')
            ->field('a.*,b.nickname')
            ->join('user b','b.id = a.user_id')
            ->where(['a.id' => $ids])
            ->find();
        if (!$row)
            $this->error(__('No Results were found'));
        $row['statusList']=$this->realModel->statusList($row['status']);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 审核通过
     */
    public function passOn(){
        $realId=input('real_id');
        $res=$this->realModel->where(['id'=>$realId])->update(['status'=>1,'update_time'=>time()]);
        if($res){
            return json(['code'=>1,'msg'=>'审核通过成功！']);
        }else{
            return json(['code'=>0,'msg'=>'操作失败，请重试！']);
        }

    }
    /**
     * 审核驳回
     */
    public function passNo(){
        $realId=input('real_id');
        $remark=input('remark');
        $res=$this->realModel->where(['id'=>$realId])->update(['status'=>2,'remark'=>$remark,'update_time'=>time()]);
        if($res){
            return json(['code'=>1,'msg'=>'审核驳回成功！']);
        }else{
            return json(['code'=>0,'msg'=>'操作失败，请重试！']);
        }

    }
}