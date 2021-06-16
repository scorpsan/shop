<?php
namespace backend\models;

use common\models\ShopPayment as BaseShopPayments;
use yii\db\ActiveQuery;
use yii2tech\ar\position\PositionBehavior;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * @property-read ActiveQuery $delivery
 * @property-read ActiveQuery $translates
 */
class ShopPayment extends BaseShopPayments
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
                    'delivery_list' => 'delivery',
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
            [['className'], 'string', 'max' => 255],
            [['published'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['delivery_list'], 'each', 'rule' => ['integer']],
            [['sorting'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'className' => Yii::t('backend', 'Class Name'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'delivery_list' => Yii::t('backend', 'Delivery Methods'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete(): bool
    {
        ShopPaymentLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getDelivery(): ActiveQuery
    {
        return $this->hasMany(ShopDelivery::class, ['id' => 'delivery_id'])->viaTable(ShopPaymentDelivery::tableName(), ['payment_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(ShopPaymentLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

    /**
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return array
     */
    public static function listAll(string $keyField = 'id', string $valueField = 'translate.title', bool $asArray = true): array
    {
        $query = static::find()->with('translate');
        if ($asArray) {
            $query->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

}