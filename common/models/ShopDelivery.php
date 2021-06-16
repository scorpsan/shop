<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\base\InvalidConfigException;
use Exception;

/**
 * @property int $id [int(11)]
 * @property float $cost [float]
 * @property int $max_weight [int(11)]
 * @property int $min_summa [int(11)]
 * @property int $max_summa [int(11)]
 * @property bool $pickup [tinyint(1)]
 * @property int $sort [int(9)]
 * @property bool $published [tinyint(1)]
 *
 * @property-read null|string $title
 * @property-read null|string $description
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $payments
 */
class ShopDelivery extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_delivery_method}}';
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getTitle(): string
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getDescription(): string
    {
        return ArrayHelper::getValue($this->translate, 'desc');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopDeliveryLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getPayments(): ActiveQuery
    {
        return $this->hasMany(ShopPayment::class, ['id' => 'payment_id'])->viaTable(ShopPaymentDelivery::tableName(), ['delivery_id' => 'id'])->andFilterWhere(['published' => true]);
    }

}