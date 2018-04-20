<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/15
 * Time: 16:50
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];
    protected $message = [
        'ids'=>'ids参数必须为以逗号分隔的多个正整数'
    ];
    protected function  checkIDs($value,$rule='',$data='',$field=''){
        $values = explode(',',$value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPositiveInteger($id))
            {
                return false;
            }
        }
        return true;
    }

}