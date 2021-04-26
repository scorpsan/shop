<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $lng [varchar(5)]
 * @property string $title [varchar(255)]
 * @property string $desc
 */
class ShopDeliveryLng extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_delivery_method_lng}}';
    }

}