<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 0:59
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule =[
        'count'=>'isPositiveInteger|between:1,15'
    ];
    protected $message=[
        'count'=>'count必须是正整数和范围在1-15之间'
    ];
}