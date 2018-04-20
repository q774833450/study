<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 0:40
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code =201;
    public $msg = 'ok';
    public $errorCode = 0;

}