<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\base\Exception;

/**
 * @property int $id [int(11)]
 * @property string $order_number [varchar(100)]
 * @property string $token [varchar(100)]
 * @property string $payment_token [char(255)]
 * @property int $user_id [int(11)]
 * @property int $delivery_method_id [int(11)]
 * @property string $delivery_method_name [varchar(255)]
 * @property float $delivery_cost [float]
 * @property int $payment_method_id [int(11)]
 * @property string $payment_method_name [varchar(255)]
 * @property float $amount [float]
 * @property float $amount_change [float]
 * @property float $discount [float]
 * @property string $currency [char(3)]
 * @property string $note
 * @property string $admin_note
 * @property string $cancel_reason
 * @property string $customer_email [char(255)]
 * @property string $customer_phone [varchar(255)]
 * @property string $customer_name [varchar(255)]
 * @property string $delivery_postal [char(10)]
 * @property string $delivery_address
 * @property string $tracker [varchar(255)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 *
 * @property-read ActiveQuery $deliveryMethod
 * @property-read ActiveQuery $paymentMethod
 * @property-read ActiveQuery $user
 * @property-read ActiveQuery $items
 * @property-read ActiveQuery $statuses
 * @property-read mixed $deliveryStatus
 * @property-read mixed $paymentStatus
 */
class ShopOrders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_number', 'token', 'delivery_method_name', 'payment_method_name', 'amount', 'currency'/*, 'customer_email'*/, 'customer_phone', 'customer_name'/*, 'delivery_address'*/], 'required'],
            [['user_id', 'delivery_method_id', 'payment_method_id'], 'integer'],
            [['delivery_cost', 'amount', 'amount_change', 'discount'], 'number'],
            [['note', 'admin_note', 'cancel_reason', 'delivery_address'], 'string'],
            [['order_number'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 64],
            [['currency'], 'string', 'max' => 3],
            [['payment_token'], 'string', 'max' => 255],
            [['delivery_method_name', 'payment_method_name', 'customer_email', 'customer_phone', 'customer_name', 'tracker'], 'string', 'max' => 255],
            [['delivery_postal'], 'string', 'max' => 10],
            [['delivery_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopDelivery::class, 'targetAttribute' => ['delivery_method_id' => 'id']],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopPayment::class, 'targetAttribute' => ['payment_method_id' => 'id']],
            [['user_id'], 'exist', 'skipOnEmpty' => true, 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (empty($this->token)) {
            $this->generateToken();
        }

        return parent::beforeValidate();
    }

    /**
     * Gets query for [[DeliveryMethod]].
     *
     * @return ActiveQuery
     */
    public function getDeliveryMethod(): ActiveQuery
    {
        return $this->hasOne(ShopDelivery::class, ['id' => 'delivery_method_id'])->with('translate');
    }

    /**
     * Gets query for [[PaymentMethod]].
     *
     * @return ActiveQuery
     */
    public function getPaymentMethod(): ActiveQuery
    {
        return $this->hasOne(ShopPayment::class, ['id' => 'payment_method_id'])->with('translate');
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[ShopOrdersItems]].
     *
     * @return ActiveQuery
     */
    public function getItems(): ActiveQuery
    {
        return $this->hasMany(ShopOrdersItems::class, ['order_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatuses(): ActiveQuery
    {
        return $this->hasMany(ShopOrdersStatuses::class, ['order_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getDeliveryStatus()
    {
        return $this->hasOne(ShopOrdersStatuses::class, ['order_id' => 'id'])->where(['type' => ShopOrdersStatuses::STATUS_TYPE_DELIVERY])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        return $this->hasOne(ShopOrdersStatuses::class, ['order_id' => 'id'])->where(['type' => ShopOrdersStatuses::STATUS_TYPE_PAYMENT])->orderBy(['created_at' => SORT_DESC]);
    }

    public function generateToken()
    {
        try {
            $this->token = Yii::$app->security->generateRandomString();
        } catch (Exception $e) {
            $this->token = $this->order_number;
        }
    }

}