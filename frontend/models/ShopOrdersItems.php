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
            'product_name' => Yii::t('frontend', 'Product'),
            'product_code' => Yii::t('frontend', 'Product Code'),
            'price' => Yii::t('frontend', 'Price'),
            'quantity' => Yii::t('frontend', 'Quantity'),
        ];
    }

}