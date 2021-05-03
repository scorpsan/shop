<?php
namespace frontend\models;

use common\models\ShopProducts as BaseShopProducts;

class ShopProducts extends BaseShopProducts
{
    /**
     * @param $idInCart
     * @return ShopProducts[]
     */
    public static function ProductsInCart($idInCart)
    {
        return self::find()->where(['published' => true])
            ->andWhere(['in', 'id', $idInCart])
            ->with('translate')
            ->with('images')
            ->with('category')
            ->with('characteristics')
            ->indexBy('id')->all();
    }

}