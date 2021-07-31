<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/27
 * Time: 14:20
 */
namespace app\admin\controller\member;
use app\common\controller\Backend;


class Power extends Backend
{
    /**
     * @var \app\admin\model\MemberPower
     */
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MemberPower');
    }

    /**
     * 会员权益列表
     */
    public function index(){
        if ($this->request->isAjax()) {
            $where=[];
            $where['deleted']=0;
            if(!empty(input('search'))){
                $where=['title'=>['like','%'.input('search').'%']];
            }
            $result=$this->model->where($where)->order('id asc')->select();
            $total = count($result);
            $result = array("total" => $total, "rows" => $result);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 添加会员权益
     */
    public function add(){
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a", [], 'strip_tags');
            //dump($params);exit;
            if ($params) {
                $this->model->create($params);
                $this->success();
            }
            $this->error();
        }
        return $this->view->fetch();
    }
    /**
     * 编辑会员权益
     */
    public function edit($ids = null){
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            $params = $this->preExcludeFields($params);

            $params['update_time']=time();
            try {
                $result = $row->allowField(true)->save($params);

                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error($row->getError());
                }
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 删除会员权益
     */
    public function del($ids = ''){
        $res=$this->model->where(['id'=>$ids])->update(['deleted'=>1]);
        if($res){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }
}