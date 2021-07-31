<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 9:33
 */
namespace app\admin\controller\article;
use app\common\controller\Backend;
use fast\Tree;
use think\Db;
class Special extends Backend
{
    protected $relationSearch = true;


    /**
     * @var \app\admin\model\articleSpecial
     * @var \app\admin\model\SpecialType
     */
    protected $model = null;
    protected $specialType = null;
    protected $sortlist = [];
    protected $sortdata = [];
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ArticleSpecial');
        $this->specialType = model('SpecialType');
    }
    public function index()
    {
        //设置过滤方法
        //$this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->alias('a')
                ->field('a.*,b.names')
                ->join('special_type b','b.id = a.type_id','left')
                ->where($where)
                ->where(['a.deleted'=>0])
                ->order($sort,$order)
                ->count();
            $list = $this->model
                ->alias('a')
                ->join('special_type b','b.id = a.type_id','left')
                ->field('a.*,b.names')
                ->where($where)
                ->where(['a.deleted'=>0])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $k=>$v){
                $list[$k]['charge']=$this->model->getCharge($v['is_charge']);
            }
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
        $tree = Tree::instance();
        $tree->init(collection($this->specialType->order('pid desc,id asc')->where(['status'=>'normal','deleted'=>0])->select())->toArray(), 'pid');
        $this->sortlist = $tree->getTreeList($tree->getTreeArray(0), 'names');
        $this->view->assign("statusList", $this->model->getStatusList());
        $sortdata = [0 => ['id' => '0', 'names' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $this->view->assign("parentList", $sortdata);
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
        $tree = Tree::instance();
        $tree->init(collection($this->specialType->order('pid desc,id asc')->where(['status'=>'normal','deleted'=>0])->select())->toArray(), 'pid');
        $this->sortlist = $tree->getTreeList($tree->getTreeArray(0), 'names');
        $this->view->assign("statusList", $this->model->getStatusList());
        $sortdata = [0 => ['id' => '0', 'names' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $row['names']=$this->specialType->where(['id'=>$row['type_id']])->value('names');
        $this->view->assign("parentList", $sortdata);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 编辑
     */
    public function detail($ids='')
    {
        $row = $this->model
            ->alias('a')
            ->field('a.*,b.names')
            ->join('special_type b','b.id = a.type_id','left')
            ->where(['a.id'=>$ids])
            ->find();
        if (!$row)
            $this->error(__('No Results were found'));

        $this->view->assign("row", $row->toArray());
        return $this->view->fetch();
    }
    /**
     * 删除
     */
    public function del($ids=''){
        Db::startTrans();
        try {
            $this->model->where(['id'=>$ids])->update(['deleted'=>1]);
            Db::name('article')->where(['special_id'=>$ids])->update(['deleted'=>1]);
           /* $special_id=$this->model->where(['id'=>$ids])->value('special_id');
            $this->ArticleSpecial->where(['id'=>$special_id])->setDec('periods',1);*/
            // $this->user
            Db::commit();
            $this->success();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
    }
}