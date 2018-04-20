<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 12:49
 */

namespace app\api\model;


use think\Model;

class Category extends  Model
{
    protected $hidden =[
        'delete_time','update_time','create_time'
    ];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

}