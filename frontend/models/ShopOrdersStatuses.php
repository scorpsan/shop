<?php
namespace frontend\models;

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
            'id' => Yii::t('frontend', 'ID'),
            'order_id' => Yii::t('frontend', 'Order ID'),
            'type' => Yii::t('frontend', 'Type'),
            'status' => Yii::t('frontend', 'Status'),
            'created_at' => Yii::t('frontend', 'Created At'),
        ];
    }

    public static function newStatus($order_id, $type, $status = 0): bool
    {
        if ($order_id && $type) {
            $newStatus = new ShopOrdersStatuses([
                'order_id' => $order_id,
                'type' => $type,
                'status' => $status,
            ]);
            return $newStatus->save();
        }

        return false;
    }

}