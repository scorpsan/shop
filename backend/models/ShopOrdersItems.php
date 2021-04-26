<?php
namespace backend\models;

use common\models\ShopOrdersItems as BaseShopOrdersItems;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%shop_orders_items}}".
 *
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
class ShopOrdersItems extends BaseShopOrdersItems
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'order_id' => Yii::t('backend', 'Order ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'product_name' => Yii::t('backend', 'Product Name'),
            'product_code' => Yii::t('backend', 'Product Code'),
            'price' => Yii::t('backend', 'Price'),
            'quantity' => Yii::t('backend', 'Quantity'),
        ];
    }

}