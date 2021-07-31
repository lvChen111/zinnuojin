<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 14:36
 */

namespace app\admin\controller\article;


use app\common\controller\Backend;
use fast\Tree;
use think\Db;
class Index extends Backend
{
    protected $relationSearch = true;


    /**
     * @var \app\admin\model\articleSpecial
     * @var \app\admin\model\SpecialType
     */
    protected $model = null;
    protected $ArticleSpecial = null;
    protected $ArticleAuthor = null;
    protected $sortlist = [];
    protected $sortdata = [];
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Article');
        $this->ArticleSpecial = model('ArticleSpecial');
        $this->ArticleAuthor = model('ArticleAuthor');
    }
    public function index()
    {
        //设置过滤方法
        //$this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->alias('a')
                ->field('a.*,a.title as art_title,b.title,b.periods,b.all_periods,c.names,d.nickname')
                ->join('article_special b','b.id = a.special_id','left')
                ->join('special_type c','c.id = b.type_id','left')
                ->join('article_author d','d.id = a.author_id','left')
                ->where($where)
                ->where(['a.deleted'=>0])
                ->order($sort,$order)
                ->count();
            $list = $this->model
                ->alias('a')
                ->field('a.*,a.title as art_title,b.title,b.periods,b.all_periods,c.names,d.nickname')
                ->join('article_special b','b.id = a.special_id','left')
                ->join('special_type c','c.id = b.type_id','left')
                ->join('article_author d','d.id = a.author_id','left')
                ->where($where)
                ->where(['a.deleted'=>0])
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
            //dump($params);die;
            if ($params) {
                //$params[''];
                Db::startTrans();
                try {
                    $this->model->create($params);
                    $this->ArticleSpecial->where(['id'=>$params['special_id']])->setInc('periods',1);
                   // $this->user
                    Db::commit();
                    return json(['code'=>1,'msg'=>'添加成功！']);
                } catch (\Exception $e) {
                    Db::rollback();
                    return json(['code'=>0,'msg'=>'添加失败！']);
                }
               /* $this->model->create($params);
                $this->success();*/
            }
            $this->error();
        }
        $this->sortlist = $this->ArticleSpecial->order('id asc')->field('id,title')->where(['status'=>'normal','deleted'=>0])->select();
        $sortdata = [0 => ['id' => '0', 'title' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $authorlist=$this->ArticleAuthor->order('id asc')->field('id,nickname')->where(['status'=>'normal','deleted'=>0])->select();
        $authordata = [0 => ['id' => '0', 'nickname' => __('None')]];
        foreach ($authorlist as $k => $v) {
            $authordata[] = $v;
        }
        $this->view->assign("authorList", $authordata);
        $this->view->assign("parentList", $sortdata);
        $this->view->assign("statusList", $this->model->getStatusList());
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
        $this->sortlist = $this->ArticleSpecial->order('id asc')->field('id,title')->where(['status'=>'normal','deleted'=>0])->select();
        $sortdata = [0 => ['id' => '0', 'title' => __('None')]];
        foreach ($this->sortlist as $k => $v) {
            $sortdata[] = $v;
        }
        $authorlist=$this->ArticleAuthor->order('id asc')->field('id,nickname')->where(['status'=>'normal','deleted'=>0])->select();
        $authordata = [0 => ['id' => '0', 'nickname' => __('None')]];
        foreach ($authorlist as $k => $v) {
            $authordata[] = $v;
        }

        $this->view->assign("authorList", $authordata);
        $this->view->assign("parentList", $sortdata);
        $this->view->assign("statusList", $this->model->getStatusList());
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
            $special_id=$this->model->where(['id'=>$ids])->value('special_id');
            //dump($special_id);
            $this->ArticleSpecial->where(['id'=>$special_id])->setDec('periods',1);
            // $this->user
            Db::commit();
            return json(['code'=>1,'msg'=>'删除成功！']);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code'=>0,'msg'=>'删除失败！']);
        }
    }


}