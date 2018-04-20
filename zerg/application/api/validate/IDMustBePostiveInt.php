<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/13
 * Time: 15:50
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{
    protected $rule= [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message=[
        'id' => 'id必须是正整数'
    ];
}