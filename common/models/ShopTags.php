<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $item_id [int(11)]
 * @property int $tag_id [int(11)]
 *
 * @property-read ActiveQuery $product
 * @property-read ActiveQuery $tag
 */
class ShopTags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_tags}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(ShopProducts::class, ['id' => 'item_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

}