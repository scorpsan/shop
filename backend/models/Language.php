<?php
namespace backend\models;

use common\models\Language as BaseLanguage;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property int $id
 * @property string $url
 * @property string $local
 * @property string $title
 * @property int $default
 * @property int $published
 */
class Language extends BaseLanguage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'local', 'title'], 'required'],
            [['url', 'local'], 'string', 'max' => 5],
            [['title'], 'string', 'max' => 255],
            [['default', 'published'], 'boolean'],
            ['default', 'default', 'value' => false],
            ['published', 'default', 'value' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'url' => Yii::t('backend', 'Url'),
            'local' => Yii::t('backend', 'Local'),
            'title' => Yii::t('backend', 'Title'),
            'default' => Yii::t('backend', 'Default'),
            'published' => Yii::t('backend', 'Published'),
        ];
    }

    /**
     * @return Language[]|ActiveRecord
     */
    public static function getLanguages()
    {
        return self::find()->where(['published' => true])->orderBy(['default' => SORT_DESC])->indexBy('url')->all();
    }

}