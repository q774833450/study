<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'adminid',
                'updatedByAttribute' => null,
                'value' => Yii::$app->admin->id,
            ],
        ];
    }
    public static function tableName()
    {
        return "{{%category}}";
    }

    public function attributeLabels()
    {
        return [
            'parentid' => '上级分类',
            'title' => '分类名称'
        ];
    }

    public function rules()
    {
        return [
            ['parentid', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题名称不能为空'],
            ['createtime', 'safe']
        ];
    }

    public function add($data)
    {
        $data['Category']['createtime'] = time();
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    public function getData()
    {
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates,&$result ,$pid = 0,$loop=1)
    {


//         $tree = [];
//        foreach($cates as $cate) {
//            if ($cate['parentid'] == $pid) {
//                $tree[] = $cate;
//                $tree = array_merge($tree, $this->getTree($cates, $cate['cateid']));
//            }
//        }

        for($i=0;$i<count($cates);$i++) {
            if ($cates[$i]['parentid'] == $pid) {
                $cates[$i]['title'] = str_repeat('|-----', $loop) . $cates[$i]['title'];
                $result[] = $cates[$i];
                $this->getTree($cates,$result, $cates[$i]['cateid'], $loop + 1);
            }
        }
        return $result;
    }

    public function setPrefix($data, $p = "|-----")
    {

        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['parentid'] != $val['parentid']) {
                    $num ++;
                }
            }
            if (array_key_exists($val['parentid'], $prefix)) {
                $num = $prefix[$val['parentid']];
            }
            $val['title'] = str_repeat($p, $num).$val['title'];
            $prefix[$val['parentid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
//        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach($tree as $cate) {
            $options[$cate['cateid']] = $cate['title'];
        }
        var_dump($options);
        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree;
//        return $tree = $this->setPrefix($tree);
    }

    public static function getMenu()
    {
        $top = self::find()->where('parentid = :pid', [":pid" => 0])->limit(11)->orderby('createtime asc')->asArray()->all();
        $data = [];
        foreach((array)$top as $k=>$cate) {
            $cate['children'] = self::find()->where("parentid = :pid", [":pid" => $cate['cateid']])->limit(10)->asArray()->all();
            $data[$k] = $cate;
        }
        return $data;
    }

}
