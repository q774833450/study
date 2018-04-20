<?php

namespace app\modules\controllers;

class DefaultController extends CommonController
{
    protected $mustlogin = ['index'];
    public function actionIndex()
    {
        $this->layout = "layout1";
        return $this->render('index');
    }
}
