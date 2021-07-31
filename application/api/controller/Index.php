<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $res=orderNumber();
        dump($res);
        /*$user_id=input('user_id');
        if(!isset($user_id)){
            dump('cd');
        }*/
        $this->success('请求成功');
    }
}
