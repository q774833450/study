<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 0:23
 */

namespace app\lib\exception;


class UserException extends  BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;

}