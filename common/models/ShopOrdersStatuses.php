<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\bootstrap4\Html;
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

    /**
     * @param null $type
     * @return array
     */
    public static function listAll($type = null): array
    {
        if ($type == self::STATUS_TYPE_DELIVERY) {
            return [
                self::ORDER_NEW => Yii::t('frontend', 'New Order'),

                self::DELIVERY_APPROVE => Yii::t('frontend', 'Order Confirmed'),
                self::DELIVERY_SEND => Yii::t('frontend', 'Order Sent'),
                self::DELIVERY_DELIVER => Yii::t('frontend', 'Order Delivered'),

                self::ORDER_CANCEL => Yii::t('frontend', 'Order Cancelled'),
            ];
        } elseif ($type == self::STATUS_TYPE_PAYMENT) {
            return [
                self::ORDER_NEW => Yii::t('frontend', 'New Order'),

                self::PAYMENTS_WAIT => Yii::t('frontend', 'Awaiting'),
                self::PAYMENTS_PAID => Yii::t('frontend', 'Paid'),
                self::PAYMENTS_CANCEL => Yii::t('frontend', 'Cancelled'),
                self::PAYMENTS_REFUND => Yii::t('frontend', 'Refund'),

                self::ORDER_CANCEL => Yii::t('frontend', 'Order Cancelled'),
            ];
        }
        return [
            self::ORDER_NEW => Yii::t('frontend', 'New Order'),

            self::PAYMENTS_WAIT => Yii::t('frontend', 'Wait'),
            self::PAYMENTS_PAID => Yii::t('frontend', 'Paid'),
            self::PAYMENTS_CANCEL => Yii::t('frontend', 'Cancel'),
            self::PAYMENTS_REFUND => Yii::t('frontend', 'Refund'),

            self::DELIVERY_APPROVE => Yii::t('frontend', 'Order Confirmed'),
            self::DELIVERY_SEND => Yii::t('frontend', 'Order Sent'),
            self::DELIVERY_DELIVER => Yii::t('frontend', 'Order Delivered'),

            self::ORDER_CANCEL => Yii::t('frontend', 'Order Cancelled'),
        ];
    }

    /**
     * @param $status
     * @return string
     */
    public static function HtmlStatus($status): string
    {
        switch ($status) {
            case self::PAYMENTS_PAID:
            case self::DELIVERY_DELIVER:
                return Html::tag('span', self::listAll()[$status], ['class' => 'badge badge-success label label-success font-size-12']);
            case self::PAYMENTS_REFUND:
                return Html::tag('span', self::listAll()[$status], ['class' => 'badge badge-warning label label-warning font-size-12']);
            case self::PAYMENTS_CANCEL:
            case self::ORDER_CANCEL:
                return Html::tag('span', self::listAll()[$status], ['class' => 'badge badge-danger label label-danger font-size-12']);
            case self::DELIVERY_SEND:
                return Html::tag('span', self::listAll()[$status], ['class' => 'badge badge-info label label-info font-size-12']);
            case self::PAYMENTS_WAIT:
            case self::DELIVERY_APPROVE:
            case self::ORDER_NEW:
            default:
                return Html::tag('span', self::listAll()[$status], ['class' => 'badge badge-primary label label-primary font-size-12']);
        }
    }

    public static function newStatus($order_id, $type, $status = 0): bool
    {
        if ($order_id && $type) {
            $newStatus = new self([
                'order_id' => $order_id,
                'type' => $type,
                'status' => $status,
            ]);
            return $newStatus->save();
        }

        return false;
    }

}