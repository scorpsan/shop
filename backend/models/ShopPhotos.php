<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shop_photos}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $file
 * @property int|null $sort
 *
 * @property ShopProducts $product
 */
class ShopPhotos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_photos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'file'], 'required'],
            [['product_id', 'sort'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'file' => Yii::t('backend', 'File'),
            'sort' => Yii::t('backend', 'Sort'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ShopProducts::className(), ['id' => 'product_id']);
    }
}
