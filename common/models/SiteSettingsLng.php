<?php
namespace common\models;

class SiteSettingsLng extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%settings_lng}}';
    }

    public function getItem() {
        return $this->hasOne(SiteSettings::className(), ['id' => 'item_id']);
    }

}