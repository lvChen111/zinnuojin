<?php
/**
 * Created by PhpStorm.
 * User: lvchen
 * Date: 2020/4/8
 * Time: 10:26
 */
namespace app\admin\controller\banner;
use app\common\controller\Backend;
class Index extends Backend
{
    protected $relationSearch = true;


    /**
     * @var \app\admin\model\BannerGroup
     */
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('BannerGroup');
       /* if(!isset($info['openid'])){
            $return['code'] = 500;
            // $return['data'] = $errCode;
            $return['msg'] = "登录认证失效，请重新登录！";
        }*/
    }
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        //$this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $where = [];
            $where['deleted'] = 0;
            if (!empty(input('search'))) {
                $where = ['a.title' => ['like', '%' . input('search') . '%']];
            }
            $list = $this->model
                ->where($where)
                ->order('id desc')
                ->select();
            $total = count($list);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 添加
     */
    public function add()
    {

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a", [], 'strip_tags');
            //dump($params);exit;
            $params['create_time']=time();
            $params['update_time']=time();
            if ($params) {
                $this->model->create($params);
                $this->success();
            }
            $this->error();
        }
        return $this->view->fetch();
    }
    public function edit($ids = null){
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            $params = $this->preExcludeFields($params);

            $params['updatetime']=time();
            try {
                //是否采用模型验证
               /* if ($this->modelValidate) {
                    $name = str_replace("\\name\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                    $row->validate($validate);
                    dump('ee');
                }exit;*/
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
}