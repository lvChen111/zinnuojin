<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/7/27
 * Time: 15:55
 */

namespace app\admin\model;


use think\Model;

class MemberGoods extends Model
{
// 表名
    protected $name = 'member_goods';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    // 追加属性
    /* protected $append = [
         'status_text'
     ];*/

    public function getStatusList()
    {
        return ['normal' => __('启用'), 'hidden' => __('禁用')];
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }
}