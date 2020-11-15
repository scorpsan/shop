<?php
namespace backend\models;

use yii\behaviors\SluggableBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use backend\components\behaviors\NestedSetsTreeBehavior;
use Yii;
use yii\db\Expression;

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
 */
class Categories extends \yii\db\ActiveRecord {

    public $parent_id;
    public $sorting;
    public $titleDefault;

    public static function tableName() {
        return '{{%categories}}';
    }

    public function behaviors() {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::className()
            ],
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find() {
        return new CategoryQuery(get_called_class());
    }

    public function rules() {
        return [
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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

    public function attributeLabels() {
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

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getContent() {
        return (isset($this->translate->content)) ? $this->translate->content : null;
    }

    public function getSeotitle() {
        return (isset($this->translate->seotitle)) ? $this->translate->seotitle : $this->getTitle();
    }

    public function getKeywords() {
        return (isset($this->translate->keywords)) ? $this->translate->keywords : null;
    }

    public function getDescription() {
        return (isset($this->translate->description)) ? $this->translate->description : null;
    }

    public function getBreadbg() {
        return (isset($this->translate->breadbg)) ? $this->translate->breadbg : null;
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(CategoriesLng::className(), ['item_id' => 'id'])->alias('translate')->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

    public function getTranslates() {
        return $this->hasMany(CategoriesLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

}