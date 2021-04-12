<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property-read mixed $item
 * @property-read mixed $tag
 *
 * @property int $item_id [int(11)]
 * @property int $tag_id [int(11)]
 */
class ShopTags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shop_tags}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getItem() {
        return $this->hasOne(ShopProducts::class, ['id' => 'item_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTag() {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

}