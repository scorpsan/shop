<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use Exception;
use yii\db\Expression;

/**
 * @property-read null $title
 * @property-read int $countProd
 * @property-read string $description
 * @property-read string $keywords
 * @property-read null|string $seotitle
 * @property-read mixed $translate
 * @property int $id [int(11)]
 * @property string $alias [varchar(255)]
 * @property bool $published [tinyint(1)]
 * @property string $logo [varchar(255)]
 * @property string $breadbg [varchar(255)]
 */
class ShopBrands extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_brands}}';
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
     * @return int
     */
    public function getCountProd()
    {
        return ShopProducts::find()->where(['brand_id' => $this->id, 'published' => true])->count();
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
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopBrandsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}