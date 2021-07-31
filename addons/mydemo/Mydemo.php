<?php

namespace addons\mydemo;

use app\common\library\Menu;
use app\common\model\User;
use fast\Date;
use think\Addons;
use think\Config;
use think\Request;
use think\Route;

/**
 * Mydemo插件
 */
class Mydemo extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            'sublist' => [
                [
                    'name'    => 'user/verify',
                    'title'   => 'Verify',
                    'icon'    => 'fa fa-table',
                    'sublist' => [
                        ['name' => 'user/verify/index', 'title' => '查看'],
                        ['name' => 'user/verify/detail', 'title' => '详情'],
                    ]
                ],
            ]
        ];
        $parent=66;
        Menu::create($menu, $parent);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete("mydemo");
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable("mydemo");
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("mydemo");
        return true;
    }

    /**
     * 会员中心边栏后
     * @return mixed
     * @throws \Exception
     */
    public function userSidenavAfter()
    {
        $request = Request::instance();
        $controllername = strtolower($request->controller());
        $actionname = strtolower($request->action());
        $data = [
            'actionname'     => $actionname,
            'controllername' => $controllername
        ];
        return $this->fetch('view/hook/user_sidenav_after', $data);
    }

}