<?php
namespace common\models;

use yii\db\ActiveRecord;

class ShopPaymentLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_payment_method_lng}}';
    }

}