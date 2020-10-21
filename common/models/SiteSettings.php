<?php
namespace common\models;

use Yii;
use yii\db\Expression;

class SiteSettings extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%settings}}';
    }

    public function getTitle() {
        return $this->translate->title;
    }

    public function getSeotitle() {
        return $this->translate->seotitle;
    }

    public function getKeywords() {
        return $this->translate->keywords;
    }

    public function getDescription() {
        return $this->translate->description;
    }

    public function getTranslates() {
        return $this->hasMany(SiteSettingsLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(SiteSettingsLng::className(), ['item_id' => 'id'])->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

}