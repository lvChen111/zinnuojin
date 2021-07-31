<?php
//生成订单编号
function orderNumber()
{
    $res = 'Znj-'.strtotime(date('YmdHis', time())) . substr(microtime(), 2, 6) . sprintf('%03d', rand(100, 999));
    return $res;
}
/*//生成随机令牌
function randToken($length = 24){
    $key='';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++)
    {
        $key .= $pattern{mt_rand(0,61)};    //生成php随机数
    }
    return $key;
}*/