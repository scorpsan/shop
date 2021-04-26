<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id [int(11)]
 * @property int $order_id [int(11)]
 * @property int $type [int(2)]
 * @property int $status [int(2)]
 * @property int $created_at [int(11)]
 *
 * @property-read ActiveQuery $order
 */
class ShopOrdersStatuses extends ActiveRecord
{
    const STATUS_TYPE_PAYMENT = 1;
    const STATUS_TYPE_DELIVERY = 2;

    const ORDER_NEW = 0;

    const PAYMENTS_WAIT = 1;
    const PAYMENTS_PAID = 2;
    const PAYMENTS_CANCEL = 3;
    const PAYMENTS_REFUND = 4;

    const DELIVERY_APPROVE = 21;
    const DELIVERY_SEND = 22;
    const DELIVERY_DELIVER = 23;

    const ORDER_CANCEL = 30;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_orders_statuses}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'type', 'status'], 'required'],
            [['order_id', 'type', 'status', 'created_at'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopOrders::class, 'targetAttribute' => ['order_id' => 'id']],
            [['created_at'], 'safe']
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return ActiveQuery
     */
    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(ShopOrders::class, ['id' => 'order_id']);
    }

}