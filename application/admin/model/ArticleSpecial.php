<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 9:40
 */

namespace app\admin\model;


use think\Model;

class ArticleSpecial extends Model
{
    // 表名
    protected $name = 'article_special';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    public function getStatusList()
    {
        return ['normal' => __('启用'), 'hidden' => __('禁用')];
    }
    public function getCharge($charge){
        $data=[
            1=>'会员免费',
            2=>'全部免费',
            3=>'全部收费费'
        ];
        return $data[$charge];
    }
}