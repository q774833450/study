<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 12:58
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    //HTTP的状态码 404，200
    public  $code=404;
    //错误的具体信息
    public  $msg='指定类目不存在，请检查参数';
    //自定义的错误码
    public  $errorCode=50000;

}