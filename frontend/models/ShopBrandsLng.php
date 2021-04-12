<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class ShopBrandsLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_brands_lng}}';
    }

}