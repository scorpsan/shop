<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\db\Expression;

/**
 * @property-read null $units
 * @property-read null $title
 * @property-read mixed $translate
 * @property int $id [int(11)]
 * @property string $alias [varchar(255)]
 * @property string $type [varchar(16)]
 * @property bool $required [tinyint(1)]
 * @property bool $published [tinyint(1)]
 * @property int $sort [int(3)]
 */
class ShopCharacteristics extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_characteristics}}';
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        if ((isset($this->translate->title))) {
            return $this->translate->title;
        } else {
            return null;
        }
    }

    /**
     * @return string|null
     */
    public function getUnits()
    {
        if ((isset($this->translate->units))) {
            return $this->translate->units;
        } else {
            return null;
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopCharacteristicsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

}