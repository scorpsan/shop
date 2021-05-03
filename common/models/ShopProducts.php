<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\db\Expression;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use Exception;

/**
 * @property int $id [int(11)]
 * @property int $category_id [int(11)]
 * @property int $brand_id [int(11)]
 * @property string $code [varchar(255)]
 * @property string $alias [varchar(255)]
 * @property int $sort [int(9)]
 * @property bool $published [tinyint(1)]
 * @property int $top [int(1)]
 * @property int $new [int(1)]
 * @property int $hit [int(11)]
 * @property string $rating [decimal(3,2)]
 * @property float $price [float]
 * @property float $sale [float]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property bool $in_stock [tinyint(1)]
 *
 * @property-read string $title
 * @property-read string $seotitle
 * @property-read string $keywords
 * @property-read string $description
 * @property-read ActiveQuery $images
 * @property-read string $imageMain
 * @property-read string $mediumImageMain
 * @property-read string $smallImageMain
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $category
 * @property-read ActiveQuery $brand
 * @property-read ActiveQuery $characteristics
 * @property-read ActiveQuery $tags
 */
class ShopProducts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_products}}';
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
     * @return string|null
     * @throws Exception
     */
    public function getSeotitle(): string
    {
        return ArrayHelper::getValue($this->translate, 'seotitle', $this->title);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getKeywords(): string
    {
        return ArrayHelper::getValue($this->translate, 'keywords', Yii::$app->params['keywords']);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDescription(): string
    {
        return ArrayHelper::getValue($this->translate, 'description', Yii::$app->params['description']);
    }

    /**
     * @return ActiveQuery
     */
    public function getImages(): ActiveQuery
    {
        return $this->hasMany(ShopPhotos::class, ['product_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'imageUrl');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getMediumImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'mediumImageUrl');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSmallImageMain(): string
    {
        return ArrayHelper::getValue($this->images[0], 'smallImageUrl');
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
     * @return ActiveQuery
     */
    public function getCharacteristics(): ActiveQuery
    {
        return $this->hasOne(ShopProductsCharacteristics::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])->viaTable(ShopTags::tableName(), ['item_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopProductsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}