<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 20:05
 */

namespace app\api\controller\v1;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use app\api\model\User as UserModel;
class Banner
{
    /**
     * 获取指定ID的banner(轮播栏)信息
     * @id banner的id号
     * @http GET
     * @url /api/v1/banner/:id
     *
     */
    public function getBanner($id){
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}