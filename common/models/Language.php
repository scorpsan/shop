<?php
namespace common\models;

class Language extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%language}}';
    }

    public static function getLanguagesList() {
        return self::find()->select(['url'])->where(['published' => true])->column();
    }

    public static function getLanguageDefault() {
        return self::findOne(['default' => true]);
    }

}