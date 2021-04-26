<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $lng [varchar(5)]
 * @property string $title [varchar(255)]
 * @property string $content
 * @property string $seotitle [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $seo_text
 * @property string $country [varchar(255)]
 */
class ShopBrandsLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_brands_lng}}';
    }

}