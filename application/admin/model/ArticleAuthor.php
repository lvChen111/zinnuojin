<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 14:23
 */

namespace app\admin\model;


use think\Model;

class ArticleAuthor extends Model
{
    // 表名
    protected $name = 'article_author';
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