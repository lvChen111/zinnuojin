<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/27
 * Time: 14:11
 */

namespace app\admin\controller\member;
use app\common\controller\Backend;

class Goods extends Backend
{
    /**
     * @var \app\admin\model\MemberPower
     */
    protected $model = null;
    protected $PowerModel = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MemberGoods');
        $this->PowerModel = model('MemberPower');
    }

    /**
     * 会员商品列表
     */
    public function index(){
        if ($this->request->isAjax()) {
            $where=[];
            $where['deleted']=0;
            if(!empty(input('search'))){
                $where=['title'=>['like','%'.input('search').'%']];
            }
            $result=$this->model
                ->where($where)
                ->order('id asc')
                ->select();
            $total = count($result);

            foreach ($result as $k=>$v){
                $power_id = explode(',',$v['power_id']);
                $power=[];
                foreach ($power_id as $ke=>$vo){
                    $powerTitle=$this->PowerModel->where(['id'=>$vo])->value('title');
                    $power[$ke]=$powerTitle;
                }
                $result[$k]['power']=implode('，',$power);
            }
            $result = array("total" => $total, "rows" => $result);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 添加会员商品
     */
    public function add(){
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a", [], 'strip_tags');
            //dump($params);exit;
            if($params['power_id'][0]==''){
                $this->error('请选择会员权益');
            }
            $params['power_id']=implode(',',$params['power_id']);
            if ($params) {
                $this->model->create($params);
                $this->success();
            }
            $this->error();
        }
        $power= $this->PowerModel->where(['deleted'=>0])->select();
        $this->view->assign("power", $power);
        return $this->view->fetch();
    }
    /**
     * 编辑会员商品
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
        $power= $this->PowerModel->where(['deleted'=>0])->select();
        $goodsPower = explode(',',$row['power_id']);
        $this->view->assign("goodsPower", $goodsPower);
        $this->view->assign("power", $power);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 删除会员商品
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