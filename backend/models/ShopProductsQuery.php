<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ShopProducts]].
 *
 * @see ShopProducts
 */
class ShopProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ShopProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShopProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
