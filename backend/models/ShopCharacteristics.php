<?php
namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%shop_characteristics}}".
 *
 * @property int $id
 * @property string $alias
 * @property string $type
 * @property int $required
 * @property int $published
 * @property int $sort
 */
class ShopCharacteristics extends \yii\db\ActiveRecord {

    public $sorting;
    public $titleDefault;

    public static function tableName() {
        return '{{%shop_characteristics}}';
    }

    public function behaviors() {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort',
            ],
        ];
    }

    public function rules() {
        return [
            [['alias', 'type'], 'required'],
            [['alias'], 'unique'],
            [['alias'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 16],
            [['published', 'required'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['required'], 'default', 'value' => false],
            [['sort'], 'integer'],
            [['sorting'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'alias' => Yii::t('backend', 'Alias'),
            'type' => Yii::t('backend', 'Type'),
            'required' => Yii::t('backend', 'Required'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
        ];
    }

    public function beforeDelete() {
        ShopCharacteristicsLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getUnits() {
        return (isset($this->translate->units)) ? $this->translate->units : null;
    }

    public function getDefault() {
        return (isset($this->translate->default)) ? $this->translate->default : null;
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopCharacteristicsLng::className(), ['item_id' => 'id'])->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

    public function getTranslates() {
        return $this->hasMany(ShopCharacteristicsLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

    public function getSortingLists() {
        $sortingList = ArrayHelper::map(self::find()->orderBy(['sort' => SORT_ASC])->all(), 'sort', 'title');
        if (count($sortingList)) {
            $sortingList = array_merge(['first' => Yii::t('backend', '- First Element -')], $sortingList, ['last' => Yii::t('backend', '- Last Element -')]);
        } else {
            $sortingList = ['last' => Yii::t('backend', '- First Element -')];
        }
        return $sortingList;
    }
}
