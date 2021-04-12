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
 * This is the model class for table "{{%shop_payment_method}}".
 *
 * @property int $id [int(11)]
 * @property string $className [varchar(255)]
 * @property int $sort [int(9)]
 * @property bool $default [tinyint(1)]
 * @property bool $published [tinyint(1)]
 *
 * @property-read null|string $title
 * @property-read null|string $description
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $translates
 */
class ShopPayment extends ActiveRecord
{
    public $sorting;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_payment_method}}';
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
            [['className'], 'string', 'max' => 255],
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
            'className' => Yii::t('backend', 'Class Name'),
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
        ShopPaymentLng::deleteAll(['item_id' => $this->id]);
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
        return $this->hasOne(ShopPaymentLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(ShopPaymentLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}