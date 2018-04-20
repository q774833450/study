<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 0:56
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\PagingParameter;
use app\lib\exception\ProductException;
use think\Controller;

class Product extends Controller
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createOne,deleteOne']
    ];
    //api/:version/product/recent
    //获取最近商品
    public function getRecent($count=15){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }

        $products = $products->hidden(['summary']);
        return $products;
    }
    //api/:version/product/by_category
    //获取特定分类下的商品
    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty())
        {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    //得到一个商品的详细信息
    public function getOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product)
        {
            throw new ProductException();
        }
        return $product;
    }
    public function createOne()
    {
        $product = new ProductModel();
        $product->save(
            [
                'id' => 1
            ]);
    }
    //删除特定商品
    public function deleteOne($id)
    {
        ProductModel::destroy($id);
        //        ProductModel::destroy(1,true);
    }
    /**
     * 根据类目ID获取该类目下所有商品(分页）
     * @url /product?id=:category_id&page=:page&size=:page_size
     * @param int $id 商品id
     * @param int $page 分页页数（可选)
     * @param int $size 每页数目(可选)
     * @return array of Product
     * @throws ParameterException
     */
    public function getByCategory($id = -1, $page = 1, $size = 30)
    {
        (new IDMustBePostiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        $pagingProducts = ProductModel::getProductsByCategoryID(
            $id, true, $page, $size);
        if ($pagingProducts->isEmpty())
        {
            // 对于分页最好不要抛出MissException，客户端并不好处理
            return [
                'current_page' => $pagingProducts->currentPage(),
                'data' => []
            ];
        }
        //数据集对象和普通的二维数组在使用上的一个最大的区别就是数据是否为空的判断，
        //二维数组的数据集判断数据为空直接使用empty
        //collection的判空使用 $collection->isEmpty()

        // 控制器很重的一个作用是修剪返回到客户端的结果

        //        $t = collection($products);
        //        $cutProducts = collection($products)
        //            ->visible(['id', 'name', 'img'])
        //            ->toArray();

//        $collection = collection($pagingProducts->items());
        $data = $pagingProducts
            ->hidden(['summary'])
            ->toArray();
        // 如果是简洁分页模式，直接序列化$pagingProducts这个Paginator对象会报错
        //        $pagingProducts->data = $data;
        return [
            'current_page' => $pagingProducts->currentPage(),
            'data' => $data
        ];
    }

}