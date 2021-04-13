<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use dosamigos\taggable\Taggable;
use yii2tech\ar\position\PositionBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\db\Expression;
use Exception;

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
 * @property Categories $category
 * @property ShopBrands $brand
 * @property-read string $title
 * @property-read string $smallImageMain
 * @property-read string $mediumImageMain
 * @property-read string $imageMain
 * @property-read mixed $images
 * @property-read mixed $translate
 * @property-read mixed $translates
 * @property-read mixed $tags
 * @property-read mixed $imagesLinks
 * @property-read mixed $imagesLinksData
 * @property-read array $sortingLists
 * @property-read ActiveQuery $characteristics
 * @property ShopCategoryAssignments $shopCategoryAssignments
 * @property ShopProductsCharacteristics $Characteristics
 */
class ShopProducts extends ActiveRecord
{
    public $titleDefault;
    public $sorting;
    public $countwishes;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
    public function rules()
    {
        return [
            [['alias', 'code'], 'string', 'max' => 255],
            [['alias', 'code'], 'unique'],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['category_id', 'brand_id', 'code'], 'required'],
            [['category_id', 'brand_id', 'sort', 'hit'], 'integer'],
            [['rating', 'price', 'sale'], 'number'],
            [['published', 'top', 'new'], 'boolean'],
            [['published'], 'default', 'value' => 1],
            [['top', 'new', 'hit'], 'default', 'value' => 0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopBrands::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['created_at', 'updated_at', 'sorting', 'tagNames'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
            'price' => Yii::t('backend', 'Price'),
            'sale' => Yii::t('backend', 'Sale'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
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
     * @return string|null
     * @throws Exception
     */
    public function getTitle(): string
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id'])->with('translate');
    }

    /**
     * @return ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(ShopBrands::class, ['id' => 'brand_id'])->with('translate');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSmallImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'smallImageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getMediumImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'mediumImageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'imageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    public function getImages(): ActiveQuery
    {
        return $this->hasMany(ShopPhotos::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getImagesLinks(): array
    {
        return ArrayHelper::getColumn($this->images, 'imageUrl');
    }

    public function getImagesLinksData(): array
    {
        return ArrayHelper::toArray($this->images, [
            ShopPhotos::class => [
                'caption' => 'url',
                'key' => 'id',
            ]
        ]);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])->viaTable(ShopTags::tableName(), ['item_id' => 'id']);
    }

    public function getWishes(): ActiveQuery
    {
        return $this->hasMany(UserWishlistItems::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopProductsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
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