<?php
namespace frontend\models;

use Yii;

class Pages extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%pages}}';
    }

    public static function findIndexPage() {
        return self::find()->where([
            'main' => true,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

    public static function findAliasPage($alias) {
        return self::find()->where([
            'alias' => $alias,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getContent() {
        return (isset($this->translate->content)) ? $this->translate->content : null;
    }

    public function getSeotitle() {
        return (isset($this->translate->seotitle)) ? $this->translate->seotitle : $this->getTitle();
    }

    public function getKeywords() {
        return (isset($this->translate->keywords)) ? $this->translate->keywords : Yii::$app->params['keywords'];
    }

    public function getDescription() {
        return (isset($this->translate->description)) ? $this->translate->description : Yii::$app->params['description'];
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PagesLng::className(), ['item_id' => 'id'])->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new \yii\db\Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

}