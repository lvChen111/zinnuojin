<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/29
 * Time: 15:31
 */
namespace app\admin\controller\special;
use app\common\controller\Backend;
use app\common\library\Menu;
class Index extends Backend
{
    protected $relationSearch = true;

    /**
     * @var \app\admin\model\Transaction
     */

    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Special');
    }
    /*//创建菜单demo
    public function install()
    {
        $menu = [
            [
                'name'    => 'special',
                'title'   => '专区管理',
                'icon'    => 'fa fa-magic',
                'sublist' => [
                    [
                        'name'    => 'special/index',
                        'title'   => '专区分类管理',
                        'icon'    => 'fa fa-table',
                        'sublist' => [
                            ['name' => 'special/index/index', 'title' => '查看'],
                            ['name' => 'special/index/edit', 'title' => '编辑'],
                            ['name' => 'special/index/add', 'title' => '添加'],
                            ['name' => 'special/index/del', 'title' => '删除'],
                        ]
                    ],
                    [
                        'name'    => 'special/special',
                        'title'   => '专区下属分类管理',
                        'icon'    => 'fa fa-table',
                        'sublist' => [
                            ['name' => 'special/special/index', 'title' => '查看'],
                            ['name' => 'special/special/add', 'title' => '添加'],
                            ['name' => 'special/special/edit', 'title' => '编辑'],
                            ['name' => 'special/special/del', 'title' => '删除'],

                        ]
                    ],
                ]
            ]
        ];

        $parent=66;
        $res=Menu::create($menu);
        return json(['code'=>$res]);
    }*/
    /**
     * 查看
     */
    public function index(){
        //设置过滤方法
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            //$sort='a.real_id';
            $total = $this->model
                ->where($where)
                ->where(['deleted'=>0])
                ->order($sort, $order)
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
    /**
     * 编辑
     */
    public function edit($ids = null){
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            $params = $this->preExcludeFields($params);

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
}