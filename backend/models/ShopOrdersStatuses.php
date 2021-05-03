<?php
namespace backend\models;

use common\models\ShopOrdersStatuses as BaseShopOrdersStatuses;
use Yii;

class ShopOrdersStatuses extends BaseShopOrdersStatuses
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'order_id' => Yii::t('backend', 'Order ID'),
            'type' => Yii::t('backend', 'Type'),
            'status' => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
        ];
    }

}