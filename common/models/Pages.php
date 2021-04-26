<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * @property int $id [int(11)]
 * @property int $category_id [int(11)]
 * @property string $alias [varchar(255)]
 * @property bool $published [tinyint(1)]
 * @property bool $main [tinyint(1)]
 * @property bool $noindex [tinyint(1)]
 * @property bool $page_style [tinyint(1)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 *
 * @property-read null|string $title
 * @property-read null|string $seotitle
 * @property-read string $keywords
 * @property-read string $description
 * @property-read array $content
 * @property-read ActiveQuery $translate
 */
class Pages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%pages}}';
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
     * @return array
     */
    public function getContent(): array
    {
        return ArrayHelper::getValue($this->translate, 'content');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PagesLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}