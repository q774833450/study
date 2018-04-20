<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 16:39
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule=[
        'code'=>'require'
    ];
    protected $message=[
        'code'=>'缺少code'
    ];
}