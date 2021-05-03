<?php
namespace backend\models;

use common\models\ShopDelivery as BaseShopDelivery;
use yii\db\ActiveQuery;
use yii2tech\ar\position\PositionBehavior;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property-read ActiveQuery $translates
 */
class ShopDelivery extends BaseShopDelivery
{
    public $sorting;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'sort',
            ],
            'linkerBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'payment_list' => 'payments',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['cost'], 'number'],
            [['max_weight', 'min_summa', 'max_summa'], 'integer'],
            [['published'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['payment_list'], 'each', 'rule' => ['integer']],
            [['sorting'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'cost' => Yii::t('backend', 'Cost Delivery'),
            'max_weight' => Yii::t('backend', 'Max Weight (gr)'),
            'min_summa' => Yii::t('backend', 'Min Summa'),
            'max_summa' => Yii::t('backend', 'Max Summa'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'payment_list' => Yii::t('backend', 'Payment Methods'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete(): bool
    {
        ShopDeliveryLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(ShopDeliveryLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

    /**
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'translate.title', $asArray = true): array
    {
        $query = static::find()->with('translate');
        if ($asArray) {
            $query->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

}