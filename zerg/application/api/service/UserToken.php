<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 16:47
 */

namespace app\api\service;


use app\api\validate\TokenGet;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;
    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(
            config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }
    //得到Token
    public function get(){
        $www = $this->wxLoginUrl;
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult))
        {
            throw new Exception("内部异常");
        }
        else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }
            else{
               return  $this->grantToken($wxResult);
            }
        }
    }
    private function grantToken($wxResult){
        //拿到openid
        $openid = $wxResult['openid'];
        //查询数据库中openid是否存在
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }
        else{
            //如果存在 则不处理，如果不存在就新增一条user记录
            $uid = $this->newUser($openid);
        }
        //生成令牌,写入缓存
        $cacheValue=$this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCahce($cacheValue);
        //把令牌返回到客户端去
        return $token;
    }
    private function saveToCahce($cachedValue){
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_time');
        $request = cache($key,$value,$expire_in);
        if(!$request){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] =$uid;
        //16代表用户的权限数值
        $cachedValue['scope'] = ScopeEnum::User;
        //32代表管理员的权限数值
        return $cachedValue;
    }
    private function newUser($openid){
        $user = UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }
    private function  processLoginError($wxResult){
        throw new WeChatException([
            'msg'=>$wxResult['errmsg'],
            'errorCode'=>$wxResult['errcode']
        ]);
    }

}