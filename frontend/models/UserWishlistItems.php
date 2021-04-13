<?php
namespace frontend\models;

use common\models\User;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property int $product_id [int(11)]
 *
 * @property-read ActiveQuery $user
 * @property-read ActiveQuery $product
 */
class UserWishlistItems extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_wishlist_items}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(ShopProducts::class, ['id' => 'product_id']);
    }

}