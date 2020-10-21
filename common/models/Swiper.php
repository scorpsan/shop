<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%swiper}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $published
 * @property bool $player
 *
 * @var $params
 * @var $options
 */
class Swiper extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%swiper}}';
    }

    public static function getOptionsList() {
        $options = [
            'id' => [
                'title' => Yii::t('backend', 'Choose slider...'),
                'dropList' => ArrayHelper::map(self::find()->where(['published' => true])->orderBy('title')->all(), 'id', 'title')
            ]
        ];
        if (isset(Yii::$app->params['widgetsList']['SwiperWidget']['options'])) {
            $options = ArrayHelper::merge($options, Yii::$app->params['widgetsList']['SwiperWidget']['options']);
        }
        return $options;
    }

}