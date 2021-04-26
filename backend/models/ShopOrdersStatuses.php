<?php
namespace backend\models;

use common\models\ShopOrdersStatuses as BaseShopOrdersStatuses;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%shop_orders_statuses}}".
 *
 * @property int $id [int(11)]
 * @property int $order_id [int(11)]
 * @property int $type [int(2)]
 * @property int $status [int(2)]
 * @property int $created_at [int(11)]
 *
 * @property-read ActiveQuery $order
 */
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