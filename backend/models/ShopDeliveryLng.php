<?php
namespace backend\models;

use common\models\ShopDeliveryLng as BaseShopDeliveryLng;
use Yii;

/**
 * This is the model class for table "{{%shop_delivery_method_lng}}".
 *
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $lng [varchar(5)]
 * @property string $title [varchar(255)]
 * @property string $desc
 */
class ShopDeliveryLng extends BaseShopDeliveryLng
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title'], 'string', 'max' => 255],
            [['desc'], 'string'],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopDelivery::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'desc' => Yii::t('backend', 'Description'),
        ];
    }

}