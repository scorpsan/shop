<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\SluggableBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use backend\components\behaviors\NestedSetsTreeBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $alias
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property int $published
 * @property int $noindex
 * @property int $page_style
 *
 * @property-read string|null $title
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $translates
 */
class Categories extends ActiveRecord
{
    public $parent_id;
    public $sorting;
    public $titleDefault;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['published', 'noindex'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['noindex'], 'default', 'value' => false],
            [['page_style'], 'integer'],
            [['page_style'], 'default', 'value' => 6],
            [['sorting'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'alias' => Yii::t('backend', 'Alias'),
            'parent_id' => Yii::t('backend', 'Parent Category'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'noindex' => Yii::t('backend', 'NoIndex'),
            'page_style' => Yii::t('backend', 'Page Style'),
            'published' => Yii::t('backend', 'Published'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->alias = str_replace(' ', '_', $this->alias);
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getTitle()
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * Gets query for [[Translate]].
     *
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(CategoriesLng::class, ['item_id' => 'id'])->alias('translate')
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * Gets query for [[Translates]].
     *
     * @return ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(CategoriesLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}