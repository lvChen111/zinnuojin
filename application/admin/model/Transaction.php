<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/29
 * Time: 10:30
 */

namespace app\admin\model;


use think\Model;

class Transaction extends Model
{
// 表名
    protected $name = 'transaction';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    //状态
    public function statusList($type,$status){
        //充值
        $data[1]=[
            '<span style="color: #ff8f23">待支付</span>',
            '<span style="color: #008800">充值成功</span>',
            '<span style="color: #ff002a">充值失败</span>'
        ];
        //提现
        $data[2]=[
            '<span style="color: #ff8f23">待审核</span>',
            '<span style="color: #008800">审核通过</span>',
            '<span style="color: #ff002a">审核驳回</span>'
        ];
        return $data[$type][$status];
    }
    public function typeList($type){
        //充值
        $data[1]= '充值';
        //提现
        $data[2]= '提现';
        return $data[$type];
    }
}