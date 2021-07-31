<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/27
 * Time: 10:03
 */

namespace app\admin\model;


use think\Model;

class UserRealinfo extends Model
{
// 表名
    protected $name = 'user_realinfo';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    //状态
    public function statusList($status){
        $data=[
            '<span style="color: #ff8f23">待审核</span>',
            '<span style="color: #008800">审核通过</span>',
            '<span style="color: #ff002a">审核驳回</span>'
        ];
        return $data[$status];
    }
}