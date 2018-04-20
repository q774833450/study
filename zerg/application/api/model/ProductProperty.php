<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 21:42
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = [
        'product_id','delete_time','id'
    ];

}