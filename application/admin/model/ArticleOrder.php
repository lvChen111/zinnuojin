<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/30
 * Time: 17:00
 */

namespace app\admin\model;


use think\Model;

class ArticleOrder extends Model
{
// 表名
    protected $name = 'article_order';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    public function getStatusList($status)
    {
        $data=[
            '待支付',
            '支付成功',
            '支付失败'
        ];
        return $data[$status];
    }
    public function getPayType($status)
    {
        $data=[
            '未选择',
            '微信',
            '支付宝',
            '余额'
        ];
        return $data[$status];
    }
}