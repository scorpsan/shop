<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class ShopProductsLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shop_products_lng}}';
    }

}