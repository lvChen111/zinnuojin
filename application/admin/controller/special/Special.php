<?php
/**
 * Created by PhpStorm.
 * User: lvchen
 * Date: 2021/7/29
 * Time: 16:15
 */
namespace app\admin\controller\special;
use app\common\controller\Backend;
use fast\Tree;
class Special extends Backend
{
    protected $relationSearch = true;


    /**
     * @var \app\admin\model\Special
     * @var \app\admin\model\SpecialType
     */
    protected $model = null;
    protected $Special = null;
    protected $sortlist = [];
    protected $sortdata = [];
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('SpecialType');
        $this->Special = model('Special');
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
                ->order('id', $order)
                ->count();
            $list = $this->model
                ->where($where)
                ->where(['deleted'=>0])
                ->order('id', $order)
                ->limit($offset, $limit)
                ->select();
            foreach($list as $k=>$v){
                if($v['pid']==0){
                    $list[$k]['p_name']='暂无';
                }else{
                    $list[$k]['p_name']=$this->model->where(['id'=>$v['pid']])->value('names');
                }
                if($v['spec_id']==0){
                    $list[$k]['title']='暂无';
                }else{
                    $list[$k]['title']=$this->Special->where(['id'=>$v['spec_id']])->value('title');
                }
            };
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
            /*dump($params);*/

            if ($params) {
                if($params['pid']==0){
                    if($params['spec_id']==0){
                        $this->error('所属专区和上级分类不能都为空');
                    }
                    $params['level']=1;
                }else{
                    $level=$this->model->where(['id'=>$params['pid']])->value('level');
                    $params['level']=$level+1;
                }
                $this->model->create($params);
                $this->success();
            }
            $this->error();
        }
        $tree = Tree::instance();
        $tree->init(collection($this->model->order('pid desc,id asc')->where(['status'=>'normal','deleted'=>0])->select())->toArray(), 'pid');
        $this->sortlist = $tree->getTreeList($tree->getTreeArray(0), 'names');
        $this->view->assign("statusList", $this->model->getStatusList());
        $sortdata = [0 => ['id' => '0', 'names' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $speclist=$this->Special->order('id asc')->field('id,title')->where(['status'=>'normal','deleted'=>0])->select();
        $specdata = [0 => ['id' => '0', 'title' => __('None')]];
        foreach ($speclist as $k => $v) {
            $specdata[] = $v;
        }
        //dump($sortdata);exit;
        $this->view->assign("specList", $specdata);
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
            if($params['pid']==0){
                if($params['spec_id']==0){
                    $this->error('所属专区和上级分类不能都为空');
                }
                $params['level']=1;
            }else{
                $level=$this->model->where(['id'=>$params['pid']])->value('level');
                $params['level']=$level+1;
            }
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
        $tree->init(collection($this->model->order('pid desc,id asc')->where(['status'=>'normal','deleted'=>0,'id'=>['neq',$row['id']]])->select())->toArray(), 'pid');
        $this->sortlist = $tree->getTreeList($tree->getTreeArray(0), 'names');
        $this->view->assign("statusList", $this->model->getStatusList());
        $sortdata = [0 => ['id' => '0', 'names' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $speclist=$this->Special->order('id asc')->field('id,title')->where(['status'=>'normal','deleted'=>0])->select();
        $specdata = [0 => ['id' => '0', 'title' => __('None')]];
        foreach ($speclist as $k => $v) {
            $specdata[] = $v;
        }
        //dump($sortdata);exit;
        $this->view->assign("specList", $specdata);
        $this->view->assign("parentList", $sortdata);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
}