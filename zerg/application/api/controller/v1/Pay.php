<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 4:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;
class Pay extends BaseController
{
    protected $beforeActionList=[
        'checkExclusiveScope'=>['only' =>'getPreOrder']
    ];
    public function getPreOrder($id = ''){
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService();
        return $pay->pay();
    }
    public function redirectNotify()
    {
        $notify = new WxNotify();
        $notify->handle();
    }

}