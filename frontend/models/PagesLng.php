<?php
namespace frontend\models;

class PagesLng extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%pages_lng}}';
    }

    public function getContent() {
        return $this->hasMany(PagesSection::className(), ['item_id' => 'id'])->andWhere(['published' => true])->orderBy(['sort' => SORT_ASC]);
    }

}