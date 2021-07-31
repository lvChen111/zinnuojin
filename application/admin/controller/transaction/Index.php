<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/29
 * Time: 10:20
 */
namespace app\admin\controller\transaction;
use app\common\controller\Backend;
use think\Db;
use app\common\library\Menu;
class Index extends Backend
{
    protected $relationSearch = true;

    /**
     * @var \app\admin\model\Transaction
     */

    protected $model = null;
    protected $User = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Transaction');
        $this->User = model('User');
    }

    /**
     * 充值查看
     */
    public function recharge()
    {
        //设置过滤方法
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
               /* ->alias('a')*/
                ->field('transaction.*,b.nickname')
                ->join('user b','b.id = transaction.user_id')
                ->where($where)
                ->where(['transaction.deleted'=>0,'transaction.type'=>1])
                ->order($sort, $order)
                ->count();
            $list = $this->model
                //->alias('a')
                ->field('transaction.*,b.nickname')
                ->join('user b','b.id = transaction.user_id')
                ->where($where)
                ->where(['transaction.deleted'=>0,'transaction.type'=>1])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            $result = array("total" => $total, "rows" => $list);
            foreach ($list as $k=>$v){
                $list[$k]['type']=$this->model->typeList($v['type']);
            }
            //dump($list);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 提现查看
     */
    public function withdrawal()
    {
        //设置过滤方法
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            //$sort='a.real_id';
            $total = $this->model
               // ->alias('a')
                ->field('transaction.*,b.nickname')
                ->join('user b','b.id = transaction.user_id')
                ->where($where)
                ->where(['deleted'=>0,'type'=>2])
                ->order($sort, $order)
                ->count();
            $list = $this->model
                //->alias('a')
                ->field('transaction.*,b.nickname')
                ->join('user b','b.id = transaction.user_id')
                ->where($where)
                ->where(['deleted'=>0,'type'=>2])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $k=>$v){
                $list[$k]['type']=$this->model->typeList($v['type']);
            }
            //dump($list);
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 详情
     */
    public function detail($ids){

        $row = $this->model
            ->alias('a')
            ->field('a.*,b.nickname')
            ->join('user b','b.id = a.user_id')
            ->where(['a.id' => $ids])
            ->find();
        if (!$row)
            $this->error(__('No Results were found'));
        $row['statusList']=$this->model->statusList($row['type'],$row['status']);
        $row['typeList']=$this->model->typeList($row['type'],$row['status']);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    public function ceshi(){
        $res = 'Znj-'.strtotime(date('YmdHis', time())) . substr(microtime(), 2, 6) . sprintf('%03d', rand(100, 999));
        //return $res;
        dump($res);
    }
    /**
     * 审核通过
     */
    public function passOn(){
        $ids=input('id');
        //提现信息
        $info = $this->model
            ->alias('a')
            ->field('a.*,b.nickname,b.openid')
            ->join('user b','b.id = a.user_id')
            ->where(['a.id' => $ids])
            ->find();
        //提现
        $Withdrawals= new Withdrawals();
        $res = $Withdrawals->sendMoney($info['amount'],$info['openid'],$info['order_no'],$desc='提现',$check_name='');
        //回调
        //dump($res);die;
        if($res != false){
            if($res['return_code']=='SUCCESS'&&$res['result_code']=='SUCCESS'){
                $this->model->where(['id'=>$ids])->update(['status'=>1,'update_time'=>time()]);
                return json(['code'=>1,'msg'=>'审核通过成功！']);
            }else{
                return json(['code'=>0,'msg'=>$res['err_code_des']]);
                //return $res['err_code_des'];
            }
        }else{
            return json(['code'=>0,'msg'=>'操作失败，请检查参数配置!']);
        }
       // if($res['return_code'])

        /*Db::startTrans();
        try {
            $this->model->where(['id'=>$ids])->update(['status'=>1,'update_time'=>time()]);
           // $this->user
            Db::commit();
            $this->success('审核通过成功!');
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }*/

        /*if($res){
            return json(['code'=>1,'msg'=>'审核通过成功！']);
        }else{
            return json(['code'=>0,'msg'=>'操作失败，请重试！']);
        }*/

    }
    /**
     * 审核驳回
     */
    public function passNo(){
        $Id=input('id');
        $remark=input('remark');
        $res=$this->model->where(['id'=>$Id])->update(['status'=>2,'remark'=>$remark,'update_time'=>time()]);
        if($res){
            return json(['code'=>1,'msg'=>'审核驳回成功！']);
        }else{
            return json(['code'=>0,'msg'=>'操作失败，请重试！']);
        }
    }

}