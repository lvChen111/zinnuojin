<?php
/**
 * Created by PhpStorm.
 * User: lvchen
 * Date: 2020/4/20
 * Time: 11:23
 */

namespace app\admin\model;


use think\Model;

class Banner extends Model
{
    protected $name = 'banner';
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