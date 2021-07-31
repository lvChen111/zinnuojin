<?php
/**
 * Created by PhpStorm.
 * User: lvchen
 * Date: 2020/4/8
 * Time: 10:29
 */

namespace app\admin\model;


use think\Model;

class BannerGroup extends Model
{
// 表名
    protected $name = 'banner_group';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

}