<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 12:49
 */

namespace app\api\controller\v1;
use app\api\model\Category as ModelCategory;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\CategoryException;

class Category
{
    //api/:version/category/all
    public  function getAllcategories(){

        $categories = ModelCategory::with('img')->select();
        if($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }
    /**
     * @url /category/:id/products
     * @return Category single
     * @throws MissException
     */
    public function getCategory($id)
    {
        $validate = new IDMustBePostiveInt();
        $validate->goCheck();
        $category = CategoryModel::getCategory($id);
        if(empty($category)){
            throw new MissException([
                'msg' => 'category not found'
            ]);
        }
        return $category;
    }

}