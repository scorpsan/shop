<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $url [varchar(255)]
 * @property int $sort [int(3)]
 *
 * @property-read string $imageUrl
 * @property-read string $mediumImageUrl
 * @property-read string $smallImageUrl
 */
class ShopPhotos extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_photos}}';
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/full_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getMediumImageUrl(): string
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/medium_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getSmallImageUrl(): string
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/small_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

}