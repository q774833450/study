<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2
 * Time: 0:04
 */

namespace app\lib\enum;


class OrderStatus
{
    //待支付
    const UNPAID = 1;
    //已经支付
    const PAID = 2;
    //已发货
    const DELIVERED = 3;
    //已经支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

}