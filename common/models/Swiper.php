<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%swiper}}".
 *
 * @property int $id [int(11)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property bool $published [tinyint(1)]
 * @property bool $player [tinyint(1)]
 *
 * @property array $params
 * @property array $options
 *
 * @property-read mixed $slides
 */
class Swiper extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%swiper}}';
    }

    public function getSlides(): ActiveQuery
    {
        return $this->hasMany(SwiperSlides::class, ['item_id' => 'id'])->orderBy('sort');
    }

}