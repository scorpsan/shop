<?php
namespace backend\models;

use common\models\Swiper as BaseSwiper;
use Yii;

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

}