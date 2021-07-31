<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 14:22
 */

namespace app\admin\controller\article;


use app\common\controller\Backend;

class Author extends Backend
{
    protected $relationSearch = true;


    /**
     * @var \app\admin\model\articleSpecial
     * @var \app\admin\model\SpecialType
     */
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ArticleAuthor');
    }
    public function index()
    {
        //设置过滤方法
        //$this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->where(['deleted'=>0])
                ->order($sort,$order)
                ->count();
            $list = $this->model
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
     * 添加
     */
    public function add()
    {

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a", [], 'strip_tags');
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
            //$params['update_time']=time();

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