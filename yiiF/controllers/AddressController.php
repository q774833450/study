<?php

namespace app\controllers;
use app\controllers\CommonController;

use Yii;
use app\models\User;
use app\models\Address;

class AddressController extends CommonController
{
    protected $mustlogin = ['del', 'add'];
    public function actionAdd()
    {
        $userid = Yii::$app->user->id;
        //$loginname = Yii::$app->session['loginname'];
        //User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['userid'] = $userid;
            $post['address'] = $post['address1'].$post['address2'];
            $data['Address'] = $post;
            $model = new Address;
            $model->load($data);
            $model->save();
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionDel()
    {
//        $loginname = Yii::$app->session['loginname'];
//        $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
        $userid = Yii::$app->user->id;
        $addressid = Yii::$app->request->get('addressid');
        if (!Address::find()->where('userid = :uid and addressid = :aid', [':uid' => $userid, ':aid' => $addressid])->one()) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        Address::deleteAll('addressid = :aid', [':aid' => $addressid]);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }










}
