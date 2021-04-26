<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * @property int $id [int(11)]
 * @property string $alias [varchar(255)]
 * @property string $type [varchar(16)]
 * @property bool $required [tinyint(1)]
 * @property bool $published [tinyint(1)]
 * @property int $sort [int(3)]
 *
 * @property-read null $title
 * @property-read null $units
 * @property-read mixed $translate
 */
class ShopCharacteristics extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_characteristics}}';
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
    public function getUnits(): string
    {
        return ArrayHelper::getValue($this->translate, 'units');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopCharacteristicsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}