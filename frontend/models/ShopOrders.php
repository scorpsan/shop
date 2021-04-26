<?php
namespace frontend\models;

use common\models\ShopOrders as BaseShopOrders;
use Yii;

class ShopOrders extends BaseShopOrders
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'order_number' => Yii::t('frontend', 'Order Number'),
            'order_id' => Yii::t('frontend', 'Order ID'),
            'user_id' => Yii::t('frontend', 'User ID'),
            'delivery_method_id' => Yii::t('frontend', 'Delivery Method ID'),
            'delivery_method_name' => Yii::t('frontend', 'Delivery Method Name'),
            'delivery_cost' => Yii::t('frontend', 'Delivery Cost'),
            'payment_method_id' => Yii::t('frontend', 'Payment Method ID'),
            'payment_method_name' => Yii::t('frontend', 'Payment Method Name'),
            'amount' => Yii::t('frontend', 'Amount'),
            'note' => Yii::t('frontend', 'Note'),
            'cancel_reason' => Yii::t('frontend', 'Cancel Reason'),
            'customer_email' => Yii::t('frontend', 'Customer Email'),
            'customer_phone' => Yii::t('frontend', 'Customer Phone'),
            'customer_name' => Yii::t('frontend', 'Customer Name'),
            'delivery_postal' => Yii::t('frontend', 'Delivery Postal'),
            'delivery_address' => Yii::t('frontend', 'Delivery Address'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
        ];
    }

}