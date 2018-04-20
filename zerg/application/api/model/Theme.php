<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/15
 * Time: 16:31
 */

namespace app\api\model;


use think\Model;

class Theme extends Model
{
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
    public function headImg(){
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }
    public static function getThemeWithProducts($id){
        $themes = self::with('products,topicImg,headImg')
            ->find($id);
        return $themes;
    }
}