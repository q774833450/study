<?php
/**
 * Created by PhpStorm.
 * User: Mr_Fu
 * Date: 2018/3/8
 * Time: 19:39
 */

namespace app\modules\models;


use yii\db\ActiveRecord;

class Auth_item extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%auth_item}}"; // TODO: Change the autogenerated stub
    }

}