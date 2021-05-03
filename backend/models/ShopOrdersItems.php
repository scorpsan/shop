<?php
namespace backend\models;

use common\models\ShopOrdersItems as BaseShopOrdersItems;
use Yii;

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