<?php
namespace backend\models;

use common\models\ShopPaymentDelivery as BaseShopPaymentDelivery;
use Yii;

class ShopPaymentDelivery extends BaseShopPaymentDelivery
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['delivery_id', 'payment_id'], 'required'],
            [['delivery_id', 'payment_id'], 'integer'],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopDelivery::class, 'targetAttribute' => ['delivery_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopPayment::class, 'targetAttribute' => ['payment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'delivery_id' => Yii::t('backend', 'Delivery ID'),
            'payment_id' => Yii::t('backend', 'Payment ID'),
        ];
    }

}