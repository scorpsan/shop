<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shop_products_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string|null $short_content
 * @property string|null $content
 * @property string|null $seotitle
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $seo_text
 *
 * @property Language $lng0
 * @property ShopProducts $item
 */
class ShopProductsLng extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_products_lng}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['short_content', 'content', 'seo_text'], 'string'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'short_content' => Yii::t('backend', 'Short Content'),
            'content' => Yii::t('backend', 'Content'),
            'seotitle' => Yii::t('backend', 'Seotitle'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'Seo Text'),
        ];
    }

    /**
     * Gets query for [[Lng0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLng0()
    {
        return $this->hasOne(Language::className(), ['url' => 'lng']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(ShopProducts::className(), ['id' => 'item_id']);
    }
}
