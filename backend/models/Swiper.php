<?php
namespace backend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%swiper}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $published
 * @property int $player
 *
 * @property-read mixed $slides
 */
class Swiper extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swiper}}';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description'], 'string', 'max' => 255],
            [['published', 'player'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['player'], 'default', 'value' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'published' => Yii::t('backend', 'Published'),
            'player' => Yii::t('backend', 'Music Play'),
        ];
    }

    public function beforeDelete()
    {
        SwiperSlides::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public function getSlides()
    {
        return $this->hasMany(SwiperSlides::class, ['item_id' => 'id'])->orderBy('sort');
    }

}