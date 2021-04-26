<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property string $product_name
 * @property string $product_code
 * @property float $price
 * @property int $quantity
 *
 * @property-read ActiveQuery $product
 */
class ShopOrdersItems extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_orders_items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'product_name', 'product_code', 'price', 'quantity'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['product_name', 'product_code'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopOrders::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(ShopProducts::class, ['id' => 'product_id'])->with('translate')->with('images');
    }

}