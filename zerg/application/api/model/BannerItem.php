<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/14
 * Time: 20:03
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['update_time','delete_time','id','img_id','banner_id'];
    public  function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}