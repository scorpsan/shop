<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id [int(11)]
 * @property int $frequency [int(11)]
 * @property string $name [varchar(100)]
 *
 * @property-read ActiveQuery $shopTags
 */
class Tags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%tags}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getShopTags(): ActiveQuery
    {
        return $this->hasMany(ShopTags::class, ['tag_id' => 'id']);
    }

}