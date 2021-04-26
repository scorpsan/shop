<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $url [varchar(5)]
 * @property string $local [varchar(5)]
 * @property string $title [varchar(255)]
 * @property bool $default [tinyint(1)]
 * @property bool $published [tinyint(1)]
 */
class Language extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%language}}';
    }

    /**
     * @return array
     */
    public static function getLanguagesList(): array
    {
        return self::find()->select(['url'])->where(['published' => true])->column();
    }

    /**
     * @return Language
     */
    public static function getLanguageDefault(): Language
    {
        return self::findOne(['default' => true]);
    }

}