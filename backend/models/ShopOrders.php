<?php
namespace backend\models;

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
            'id' => Yii::t('backend', 'ID'),
            'order_number' => Yii::t('backend', 'Order Number'),
            'token' => Yii::t('backend', 'Token'),
            'payment_token' => Yii::t('backend', 'Payment Token'),
            'user_id' => Yii::t('backend', 'User ID'),
            'delivery_method_id' => Yii::t('backend', 'Delivery Method ID'),
            'delivery_method_name' => Yii::t('backend', 'Delivery Method Name'),
            'delivery_cost' => Yii::t('backend', 'Delivery Cost'),
            'payment_method_id' => Yii::t('backend', 'Payment Method ID'),
            'payment_method_name' => Yii::t('backend', 'Payment Method Name'),
            'amount' => Yii::t('backend', 'Amount'),
            'amount_change' => Yii::t('backend', 'Amount Change'),
            'discount' => Yii::t('backend', 'Discount'),
            'currency' => Yii::t('backend', 'Currency Code'),
            'note' => Yii::t('backend', 'Comment'),
            'admin_note' => Yii::t('backend', 'Admin Note'),
            'cancel_reason' => Yii::t('backend', 'Cancel Reason'),
            'customer_email' => Yii::t('backend', 'Customer Email'),
            'customer_phone' => Yii::t('backend', 'Customer Phone'),
            'customer_name' => Yii::t('backend', 'Customer Name'),
            'delivery_postal' => Yii::t('backend', 'Delivery Postal'),
            'delivery_address' => Yii::t('backend', 'Delivery Address'),
            'tracker' => Yii::t('backend', 'Delivery Tracker'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

}