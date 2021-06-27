<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * @property int $id [int(11)]
 * @property string $alias [varchar(255)]
 * @property int $tree [int(11)]
 * @property int $lft [int(11)]
 * @property int $rgt [int(11)]
 * @property int $depth [int(11)]
 * @property bool $published [tinyint(1)]
 * @property bool $noindex [tinyint(1)]
 * @property bool $page_style [tinyint(1)]
 *
 * @property-read string $title
 * @property-read string $seotitle
 * @property-read string $keywords
 * @property-read string $description
 * @property-read ActiveQuery $translate
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
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
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