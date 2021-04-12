<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\db\Expression;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use Exception;

/**
 * @property-read null|string $seotitle
 * @property-read mixed $characteristics
 * @property-read mixed $images
 * @property-read mixed $smallImageMain
 * @property-read null|string $keywords
 * @property-read mixed $mediumImageMain
 * @property-read null|string $description
 * @property-read null $title
 * @property-read mixed $translate
 * @property-read null $tags
 * @property-read mixed $imageMain
 * @property-read mixed $category
 * @property-read mixed $brand
 *
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
 */
class ShopProducts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_products}}';
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getTitle()
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getSeotitle()
    {
        return ArrayHelper::getValue($this->translate, 'seotitle');
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getKeywords()
    {
        return ArrayHelper::getValue($this->translate, 'keywords', Yii::$app->params['keywords']);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDescription()
    {
        return ArrayHelper::getValue($this->translate, 'description', Yii::$app->params['description']);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSmallImageMain()
    {
        return ArrayHelper::getValue($this->images[0], 'smallImageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    /**
     * @return string
     */
    public function getMediumImageMain()
    {
        return ArrayHelper::getValue($this->images[0], 'mediumImageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    /**
     * @return string
     */
    public function getImageMain()
    {
        return ArrayHelper::getValue($this->images[0], 'imageUrl', Yii::getAlias('@images/nophoto.svg'));
    }

    /**
     * @return ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(ShopPhotos::class, ['product_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id'])->with('translate');
    }

    /**
     * @return ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ShopBrands::class, ['id' => 'brand_id'])->with('translate');
    }

    /**
     * @return ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasOne(ShopProductsCharacteristics::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery|null
     */
    public function getTags()
    {
        try {
            return $this->hasMany(Tags::class, ['id' => 'tag_id'])
                ->viaTable(ShopTags::tableName(), ['item_id' => 'id']);
        } catch (InvalidConfigException $e) {
            return null;
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopProductsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}