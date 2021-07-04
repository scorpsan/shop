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
 * @property string $breadbg [varchar(255)]
 * @property bool $published [tinyint(1)]
 * @property bool $noindex [tinyint(1)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property int $hit [int(11)]
 *
 * @property-read string $title
 * @property-read string $seotitle
 * @property-read string $keywords
 * @property-read string $description
 * @property-read array $content
 * @property-read string $image
 * @property-read ActiveQuery $category
 * @property-read ActiveQuery $translate
 */
class Posts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%posts}}';
    }

    /**
     * @return string
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
     * @return array
     * @throws Exception
     */
    public function getContent(): array
    {
        return ArrayHelper::getValue($this->translate, 'content');
    }

    public function getImage(): string
    {
        return $this->breadbg;
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
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PostsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}