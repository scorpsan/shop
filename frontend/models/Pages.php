<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use Exception;
use yii\db\Expression;

/**
 * @property-read null $seotitle
 * @property-read mixed $keywords
 * @property-read mixed $description
 * @property-read null $title
 * @property-read mixed $translate
 * @property-read null $content
 *
 * @property int $id [int(11)]
 * @property int $category_id [int(11)]
 * @property string $alias [varchar(255)]
 * @property bool $published [tinyint(1)]
 * @property bool $main [tinyint(1)]
 * @property bool $noindex [tinyint(1)]
 * @property bool $page_style [tinyint(1)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Pages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @return Pages|ActiveRecord|null
     */
    public static function findIndexPage()
    {
        return self::find()->where([
            'main' => true,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

    /**
     * @param $alias
     * @return Pages|ActiveRecord|null
     */
    public static function findAliasPage($alias)
    {
        return self::find()->where([
            'alias' => $alias,
            'published' => true,
        ])->with('translate')->limit(1)->one();
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
     * @return string|null
     * @throws Exception
     */
    public function getContent() {
        return ArrayHelper::getValue($this->translate, 'content');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PagesLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}