<?php
namespace common\models;

use yii\db\ActiveRecord;

class SwiperSlides extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%swiper_slides}}';
    }

}