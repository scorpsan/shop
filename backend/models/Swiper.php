<?php
namespace backend\models;

use common\models\Swiper as BaseSwiper;
use Yii;
use yii\helpers\ArrayHelper;

class Swiper extends BaseSwiper
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title', 'description'], 'string', 'max' => 255],
            [['published', 'player'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['player'], 'default', 'value' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'published' => Yii::t('backend', 'Published'),
            'player' => Yii::t('backend', 'Music Play'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete(): bool
    {
        SwiperSlides::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public static function getOptionsList(): array
    {
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