<?php
namespace common\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class Swiper
 * @package common\models
 * @var $id integer
 * @var $title string
 * @var $params array
 * @var $options array
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

    public function getSlides() {
        return $this->hasMany(SwiperSlides::className(), ['item_id' => 'id'])->orderBy('sort');
    }

}