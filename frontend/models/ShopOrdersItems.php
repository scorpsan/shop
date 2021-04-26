<?php
namespace frontend\models;

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
            'id' => Yii::t('frontend', 'ID'),
            'order_id' => Yii::t('frontend', 'Order ID'),
            'product_id' => Yii::t('frontend', 'Product ID'),
            'product_name' => Yii::t('frontend', 'Product Name'),
            'product_code' => Yii::t('frontend', 'Product Code'),
            'price' => Yii::t('frontend', 'Price'),
            'quantity' => Yii::t('frontend', 'Quantity'),
        ];
    }

}