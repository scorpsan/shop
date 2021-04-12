<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property-read mixed $shopTags
 * @property int $id [int(11)]
 * @property int $frequency [int(11)]
 * @property string $name [varchar(100)]
 */
class Tags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getShopTags()
    {
        return $this->hasMany(ShopTags::class, ['tag_id' => 'id']);
    }

}