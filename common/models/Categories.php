<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * @property-read null|string $seotitle
 * @property-read null|string $keywords
 * @property-read null|string $description
 * @property-read null|string $title
 * @property-read mixed $translate
 *
 * @property int $id [int(11)]
 * @property string $alias [varchar(255)]
 * @property int $tree [int(11)]
 * @property int $lft [int(11)]
 * @property int $rgt [int(11)]
 * @property int $depth [int(11)]
 * @property bool $published [tinyint(1)]
 * @property bool $noindex [tinyint(1)]
 * @property bool $page_style [tinyint(1)]
 */
class Categories extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%categories}}';
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
        return ArrayHelper::getValue($this->translate, 'seotitle');
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
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(CategoriesLng::class, ['item_id' => 'id'])->alias('translate')
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}