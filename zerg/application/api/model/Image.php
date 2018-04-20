<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/15
 * Time: 13:26
 */

namespace app\api\model;


use think\Model;

class Image extends  BaseModel
{
    protected $visible =['url'];

    protected function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);

    }

}