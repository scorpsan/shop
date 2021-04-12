<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class Country
 * @package common\models
 *
 * @property int $id [int(11)]
 * @property string $iso [varchar(2)]
 * @property string $name [varchar(80)]
 * @property string $nicename [varchar(80)]
 * @property string $iso3 [varchar(3)]
 * @property int $numcode [smallint(6)]
 * @property int $phonecode [int(5)]
 */
class Country extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
    public static function tableName(): string
    {
        return '{{%country}}';
    }

    /**
     * @return array
     */
    public static function getCountryList(): array
    {
        return ArrayHelper::map(self::find()->all(), 'name', 'nicename');
    }

    /**
     * @param $code string
     * @return string
     */
    public static function getCountryName($code): string
    {
        return self::find()->select('nicename')->where(['name' => $code])->scalar();
    }

	/**
	 * @return string
	 */
    public static function getUserCountryByLocation(): string
    {
		return self::find()->select('name')->where(['iso' => Yii::$app->params['userCountryCode']])->scalar();
	}

}