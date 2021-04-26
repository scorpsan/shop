<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%shop_payment_delivery}}".
 *
 * @property int $delivery_id [int(11)]
 * @property int $payment_id [int(11)]
 *
 * @property-read ActiveQuery $delivery
 * @property-read ActiveQuery $payment
 */
class ShopPaymentDelivery extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_payment_delivery}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getDelivery(): ActiveQuery
    {
        return $this->hasOne(ShopDelivery::class, ['id' => 'delivery_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPayment(): ActiveQuery
    {
        return $this->hasOne(ShopPayment::class, ['id' => 'payment_id']);
    }

}