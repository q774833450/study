<?php
/**getBanner
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/15
 * Time: 16:30
 */

namespace app\api\model;


use app\lib\exception\ProductException;
use think\Model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time','main_img_id','pivot','category_id',
        'create_time','update_time'
    ];
    public  function  getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }
    public  function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }
    public  static function getMostRecent($count){
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }
    //api/:version/product/by_category?id=
    public static function getProductsByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)
            ->select();
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    public static function getProductDetail($id){
        $products = self::with(
            [
                'imgs' => function ($query)
                {
                    $query->with(['imgUrl'])
                        ->order('order', 'asc');
                }])
            ->with('properties')
            ->find($id);
        return $products;
    }
}