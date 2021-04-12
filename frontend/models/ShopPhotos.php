<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * @property-read string $smallImageUrl
 * @property-read string $imageUrl
 * @property-read string $mediumImageUrl
 * @property int $id [int(11)]
 * @property int $product_id [int(11)]
 * @property string $url [varchar(255)]
 * @property int $sort [int(3)]
 */
class ShopPhotos extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_photos}}';
    }

    /**
     * @return string
     */
    public function getSmallImageUrl()
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/small_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getMediumImageUrl()
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/medium_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        if (isset($this->url)) {
            return Yii::getAlias('@files/products/' . $this->product_id . '/full_') . $this->url;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

}