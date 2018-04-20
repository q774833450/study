<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/13
 * Time: 17:27
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['update_time','delete_time'];
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
//    public function items2(){
//        如果要关联第二张表，另一边用数组的形式
//    }
    public static function getBannerById($id){
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}