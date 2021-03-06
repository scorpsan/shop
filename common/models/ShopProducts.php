<?php
namespace common\models;

use backend\controllers\AppController;
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
 * @property float $weight [int(11)]
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
     * @return string
     * @throws Exception
     */
    public function getSeotitle(): string
    {
        if ($this->translate->seotitle)
            return ArrayHelper::getValue($this->translate, 'seotitle');
        else
            return $this->title;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getKeywords(): string
    {
        if ($this->translate->keywords)
            return ArrayHelper::getValue($this->translate, 'keywords');
        else
            return Yii::$app->params['keywords'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDescription(): string
    {
        if ($this->translate->description)
            return ArrayHelper::getValue($this->translate, 'description');
        else
            return Yii::$app->params['description'];
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
     */
    public function getImageMain(): string
    {
        if (isset($this->images[0])) {
            return $this->images[0]->imageUrl;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getMediumImageMain(): string
    {
        if (isset($this->images[0])) {
            return $this->images[0]->mediumImageUrl;
        }
        return Yii::getAlias('@images/nophoto.svg');
    }

    /**
     * @return string
     */
    public function getSmallImageMain(): string
    {
        if (isset($this->images[0])) {
            return $this->images[0]->smallImageUrl;
        }
        return Yii::getAlias('@images/nophoto.svg');
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