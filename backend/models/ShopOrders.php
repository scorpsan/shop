<?php
namespace backend\models;

use common\models\ShopOrders as BaseShopOrders;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%shop_orders}}".
 *
 * @property int $id
 * @property string $order_number
 * @property string|null $order_id
 * @property int|null $user_id
 * @property int|null $delivery_method_id
 * @property string $delivery_method_name
 * @property float|null $delivery_cost
 * @property int|null $payment_method_id
 * @property string $payment_method_name
 * @property float|null $amount
 * @property string|null $note
 * @property string|null $cancel_reason
 * @property string|null $customer_email
 * @property string|null $customer_phone
 * @property string|null $customer_name
 * @property string|null $delivery_postal
 * @property string|null $delivery_address
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read ActiveQuery $user
 * @property-read ActiveQuery $items
 * @property-read ActiveQuery $deliveryMethod
 * @property-read ActiveQuery $paymentMethod
 */
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
            'order_id' => Yii::t('backend', 'Order ID'),
            'user_id' => Yii::t('backend', 'User ID'),
            'delivery_method_id' => Yii::t('backend', 'Delivery Method ID'),
            'delivery_method_name' => Yii::t('backend', 'Delivery Method Name'),
            'delivery_cost' => Yii::t('backend', 'Delivery Cost'),
            'payment_method_id' => Yii::t('backend', 'Payment Method ID'),
            'payment_method_name' => Yii::t('backend', 'Payment Method Name'),
            'amount' => Yii::t('backend', 'Amount'),
            'note' => Yii::t('backend', 'Note'),
            'cancel_reason' => Yii::t('backend', 'Cancel Reason'),
            'customer_email' => Yii::t('backend', 'Customer Email'),
            'customer_phone' => Yii::t('backend', 'Customer Phone'),
            'customer_name' => Yii::t('backend', 'Customer Name'),
            'delivery_postal' => Yii::t('backend', 'Delivery Postal'),
            'delivery_address' => Yii::t('backend', 'Delivery Address'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

}