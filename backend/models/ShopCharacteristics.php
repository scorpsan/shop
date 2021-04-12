<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\SluggableBehavior;
use yii2tech\ar\position\PositionBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * This is the model class for table "{{%shop_characteristics}}".
 *
 * @property int $id
 * @property string $alias
 * @property string $type
 * @property int $required
 * @property int $published
 * @property int $sort
 *
 * @property-read mixed $translate
 * @property-read mixed $title
 * @property-read array $sortingLists
 * @property-read mixed $translates
 */
class ShopCharacteristics extends ActiveRecord
{
    public $titleDefault;
    public $sorting;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_characteristics}}';
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
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'sort',
            ],
        ];
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
            [['type'], 'required'],
            [['type'], 'string', 'max' => 16],
            [['published', 'required'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['required'], 'default', 'value' => false],
            [['sort'], 'integer'],
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
            'type' => Yii::t('backend', 'Type'),
            'required' => Yii::t('backend', 'Required'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
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
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        ShopCharacteristicsLng::deleteAll(['item_id' => $this->id]);
        Yii::$app->db->createCommand()
            ->dropColumn(ShopProductsCharacteristics::tableName(), $this->alias)
            ->execute();
        return parent::beforeDelete();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getTitle()
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopCharacteristicsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(ShopCharacteristicsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

    /**
     * @return array
     */
    public function getSortingLists()
    {
        $sortingList = ArrayHelper::map(self::find()->orderBy(['sort' => SORT_ASC])->all(), 'sort', 'title');
        if (count($sortingList)) {
            $sortingList = array_merge(['first' => Yii::t('backend', '- First Element -')], $sortingList, ['last' => Yii::t('backend', '- Last Element -')]);
        } else {
            $sortingList = ['last' => Yii::t('backend', '- First Element -')];
        }
        return $sortingList;
    }

    /**
     * @param $alias
     * @return array
     */
    public static function dropList($alias)
    {
        $items = ShopProductsCharacteristics::find()->select($alias)->where(['like', $alias, '%' . '%', false])->groupBy($alias)->all();
        return array_column($items, $alias, $alias);
    }

}