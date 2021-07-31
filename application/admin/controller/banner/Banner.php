<?php
/**
 * Created by PhpStorm.
 * User: lvchen
 * Date: 2020/4/20
 * Time: 13:44
 */

namespace app\admin\controller\banner;


use app\common\controller\Backend;
use fast\Tree;
use think\Exception;
class Banner extends Backend
{
    /**
     * @var \app\admin\model\User
     */
    protected $BannerGroup = null;
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('banner');
        $this->BannerGroup = model('BannerGroup');

    }

    /**
     * 轮播
     * 查看 banner
     */
    public function index()
    {
        if ($this->request->isAjax()) {
           /* $where = [];
            if (!empty(input('search'))) {
                $where = ['a.title' => ['like', '%' . input('search') . '%']];
            }*/
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            //$sort='a.real_id';
            $total = $this->model
                ->alias('a')
                ->field('a.*,b.names')
                ->join('fa_banner_group b', 'b.id = a.group_id', 'left')
                ->where($where)
                ->where(['deleted'=>0])
                ->order('a.id desc')
                ->limit($offset, $limit)
                ->count();
            $list = $this->model
                ->alias('a')
                ->field('a.*,b.names')
                ->join('fa_banner_group b', 'b.id = a.group_id', 'left')
                ->where($where)
                ->where(['deleted'=>0])
                ->order('a.id desc')
                ->limit($offset, $limit)
                ->select();
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加banner
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a", [], 'strip_tags');
            //dump($params);exit;
           /* $params['create_time'] = time();
            $params['update_time'] = time();*/
            if ($params) {
                $this->model->create($params);
                $this->success();
            }
            $this->error();
        }
        $parentList=[];
        $group=$this->BannerGroup->field('id,names')->where(['deleted'=>0,'status'=>'normal'])->select();
        $parentList[0]=['id' => '', 'names' => __('None')];
        foreach ($group as $k=>$v){
            $parentList[$k+1]=$v;
        }

        $this->view->assign("parentList", $parentList);
        return $this->view->fetch();
    }

    /**
     * 编辑新闻分类
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
        $parentList=[];
        $group=$this->BannerGroup->field('id,names')->where(['deleted'=>0,'status'=>'normal'])->select();
        $parentList[0]=['id' => '', 'names' => __('None')];
        foreach ($group as $k=>$v){
            $parentList[$k+1]=$v;
        }

        $this->view->assign("parentList", $parentList);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 编辑新闻分类
     */
    public function del($ids = null){
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();

            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
}