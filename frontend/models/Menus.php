<?php
namespace frontend\models;

use backend\components\behaviors\NestedSetsTreeBehavior;
//use common\components\behaviors\NestedSetsTreeBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\Expression;
use yii\validators\UrlValidator;
use yii\helpers\Url;

class Menus extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%menus}}';
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::className()
            ],
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find() {
        return new MenusQuery(get_called_class());
    }

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getLabel() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getFullUrl() {
        $validator = new UrlValidator();
        $url = $this->url;
        if (!empty($url) && !$validator->validate($url, $error) && $url != '#') {
            if (isset($this->params) && !empty($this->params)) {
                $url = [$url] + unserialize($this->params);
            } else {
                $url = [$url];
            }
            if (isset($this->anchor) && !empty($this->anchor)) {
                $url += ['#' => $this->anchor];
            }
        } else {
            if (isset($this->anchor) && !empty($this->anchor)) {
                $url .= '#' . $this->anchor;
            }
        }
        if (!empty($url)) {
            return Url::to($url);
        } else {
            return false;
        }
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(MenusLng::className(), ['item_id' => 'id'])->alias('translate')->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

    public static function getMenuItems($type) {
        $root = self::find()->where(['url' => $type, 'depth' => 0])->limit(1)->one();
        if (!empty($root)) {
            return $root->menuTree($type);
        }
        return null;
    }

}