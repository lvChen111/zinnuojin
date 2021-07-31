<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/29
 * Time: 16:19
 */

namespace app\admin\model;


use think\Model;

class SpecialType extends Model
{
// 表名
    protected $name = 'special_type';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    public function getStatusList()
    {
        return ['normal' => __('启用'), 'hidden' => __('禁用')];
    }
}