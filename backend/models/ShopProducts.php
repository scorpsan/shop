<?php
namespace backend\models;

use backend\controllers\AppController;
use common\models\ShopProducts as BaseShopProducts;
use yii\db\ActiveQuery;
use dosamigos\taggable\Taggable;
use yii2tech\ar\position\PositionBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * @property-read array $imagesLinks
 * @property-read array $imagesLinksData
 * @property-read ActiveQuery $shopCategoryAssignments
 * @property-read ActiveQuery $translates
 * @property-read array $sortingLists
 * @property-read ActiveQuery $wishes
 */
class ShopProducts extends BaseShopProducts
{
    public $titleDefault;
    public $sorting;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            Taggable::class,
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'sort',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['alias', 'code'], 'string', 'max' => 255],
            [['alias', 'code'], 'unique'],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['category_id', 'brand_id', 'code'], 'required'],
            [['category_id', 'brand_id', 'sort', 'hit', 'weight'], 'integer'],
            [['rating', 'price', 'sale'], 'number'],
            [['published', 'top', 'new', 'in_stock'], 'boolean'],
            [['published'], 'default', 'value' => 1],
            [['top', 'new', 'hit', 'in_stock'], 'default', 'value' => 0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopBrands::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['created_at', 'updated_at', 'sorting', 'tagNames'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category'),
            'brand_id' => Yii::t('backend', 'Brand'),
            'code' => Yii::t('backend', 'Code'),
            'alias' => Yii::t('backend', 'Alias'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'published' => Yii::t('backend', 'Published'),
            'top' => Yii::t('backend', 'Top'),
            'new' => Yii::t('backend', 'New'),
            'hit' => Yii::t('backend', 'Hit'),
            'wishes' => Yii::t('backend', 'Wish'),
            'rating' => Yii::t('backend', 'Rating'),
            'weight' => Yii::t('backend', 'Weight (gr)'),
            'price' => Yii::t('backend', 'Price'),
            'sale' => Yii::t('backend', 'Sale'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'in_stock' => Yii::t('backend', 'In Stock'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->alias = str_replace(' ', '_', $this->alias);
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            if ($this->created_at) {
                $this->created_at = Yii::$app->formatter->asTimestamp($this->created_at);
            } else {
                $this->created_at = time();
            }
        } else {
            if ($this->created_at) {
                $this->created_at = Yii::$app->formatter->asTimestamp($this->created_at);
            } else {
                $this->created_at = $this->getOldAttribute('created_at');
            }
        }
        $this->updated_at = time();
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete(): bool
    {
        ShopProductsCharacteristics::deleteAll(['product_id' => $this->id]);
        ShopPhotos::deleteAll(['product_id' => $this->id]);
        FileHelper::removeDirectory(Yii::getAlias('@filesroot/products/' . $this->id . '/'));
        ShopProductsLng::deleteAll(['item_id' => $this->id]);
        UserWishlistItems::deleteAll(['product_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getImages(): ActiveQuery
    {
        return $this->hasMany(ShopPhotos::class, ['product_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return array
     */
    public function getImagesLinks(): array
    {
        return ArrayHelper::getColumn($this->images, 'imageUrl');
    }

    /**
     * @return array
     */
    public function getImagesLinksData(): array
    {
        return ArrayHelper::toArray($this->images, [
            ShopPhotos::class => [
                'caption' => 'url',
                'key' => 'id',
            ]
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getWishes(): ActiveQuery
    {
        return $this->hasMany(UserWishlistItems::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(ShopProductsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

    /**
     * @return array
     */
    public function getSortingLists(): array
    {
        $sortingList = ArrayHelper::map(self::find()->orderBy(['sort' => SORT_ASC])->all(), 'sort', 'title');
        if (count($sortingList)) {
            $sortingList = array_merge(['first' => Yii::t('backend', '- First Element -')], $sortingList, ['last' => Yii::t('backend', '- Last Element -')]);
        } else {
            $sortingList = ['last' => Yii::t('backend', '- First Element -')];
        }
        return $sortingList;
    }

    /**
     * Gets query for [[ShopCategoryAssignments]].
     *
     * @return ActiveQuery
     */
    public function getShopCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(ShopCategoryAssignments::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Characteristics]].
     *
     * @return ActiveQuery
     */
    public function getCharacteristics(): ActiveQuery
    {
        return $this->hasMany(ShopProductsCharacteristics::class, ['product_id' => 'id']);
    }

}