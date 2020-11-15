<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%shop_products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $brand_id
 * @property string $code
 * @property string $alias
 * @property int $sort
 * @property int $published
 * @property int $top
 * @property int $new
 * @property int|null $hit
 * @property float|null $rating
 * @property float|null $price
 * @property float|null $sale
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ShopCategoryAssignments[] $shopCategoryAssignments
 * @property ShopPhotos[] $shopPhotos
 * @property Categories $category
 * @property ShopBrands $brand
 * @property ShopProductsCharacteristics[] $shopProductsCharacteristics
 * @property ShopProductsLng[] $shopProductsLngs
 */
class ShopProducts extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%shop_products}}';
    }

    public function behaviors() {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'brand_id', 'code', 'alias', 'sort', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'brand_id', 'sort', 'published', 'top', 'new', 'hit', 'created_at', 'updated_at'], 'integer'],
            [['rating', 'price', 'sale'], 'number'],
            [['code', 'alias'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopBrands::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category ID'),
            'brand_id' => Yii::t('backend', 'Brand ID'),
            'code' => Yii::t('backend', 'Code'),
            'alias' => Yii::t('backend', 'Alias'),
            'sort' => Yii::t('backend', 'Sort'),
            'published' => Yii::t('backend', 'Published'),
            'top' => Yii::t('backend', 'Top'),
            'new' => Yii::t('backend', 'New'),
            'hit' => Yii::t('backend', 'Hit'),
            'rating' => Yii::t('backend', 'Rating'),
            'price' => Yii::t('backend', 'Price'),
            'sale' => Yii::t('backend', 'Sale'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ShopCategoryAssignments]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getShopCategoryAssignments()
    {
        return $this->hasMany(ShopCategoryAssignments::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ShopPhotos]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getShopPhotos()
    {
        return $this->hasMany(ShopPhotos::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ShopBrands::className(), ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[ShopProductsCharacteristics]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getShopProductsCharacteristics()
    {
        return $this->hasMany(ShopProductsCharacteristics::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ShopProductsLngs]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getShopProductsLngs()
    {
        return $this->hasMany(ShopProductsLng::className(), ['item_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ShopProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShopProductsQuery(get_called_class());
    }
}
