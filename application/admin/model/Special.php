<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/29
 * Time: 15:33
 */

namespace app\admin\model;


use think\Model;

class Special extends Model
{
    // 表名
    protected $name = 'special';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    public function getStatusList()
    {
        return ['normal' => __('启用'), 'hidden' => __('禁用')];
    }
    /*public function isMember()
    {
        return ['', 'hidden' => __('禁用')];
    }*/
}