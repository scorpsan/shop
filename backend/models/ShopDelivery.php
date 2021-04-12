<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii2tech\ar\position\PositionBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * This is the model class for table "{{%shop_delivery_method}}".
 *
 * @property int $id [int(11)]
 * @property float $cost [float]
 * @property int $max_weight [int(11)]
 * @property int $min_summa [int(11)]
 * @property int $max_summa [int(11)]
 * @property int $sort [int(9)]
 * @property bool $default [tinyint(1)]
 * @property bool $published [tinyint(1)]
 *
 * @property-read null|string $title
 * @property-read null|string $description
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $translates
 */
class ShopDelivery extends ActiveRecord
{
    public $sorting;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_delivery_method}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
            [['cost'], 'number'],
            [['max_weight', 'min_summa', 'max_summa'], 'integer'],
            [['default', 'published'], 'boolean'],
            [['default'], 'default', 'value' => false],
            [['published'], 'default', 'value' => true],
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
            'cost' => Yii::t('backend', 'Cost Delivery'),
            'max_weight' => Yii::t('backend', 'Max Weight'),
            'min_summa' => Yii::t('backend', 'Min Summa'),
            'max_summa' => Yii::t('backend', 'Max Summa'),
            'default' => Yii::t('backend', 'Default'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        ShopDeliveryLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
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
    public function getDescription()
    {
        return ArrayHelper::getValue($this->translate, 'desc');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopDeliveryLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(ShopDeliveryLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}