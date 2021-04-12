<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class ShopCharacteristicsLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shop_characteristics_lng}}';
    }

}