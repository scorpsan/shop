<?php
namespace backend\models;

use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%swiper_slides}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property int $published
 * @property int $sort
 * @property string $text_align
 * @property int $style
 * @property string $lng
 * @property int $start_at
 * @property int $end_at
 */
class SwiperSlides extends \yii\db\ActiveRecord {

    public $sorting;

    public static function tableName() {
        return '{{%swiper_slides}}';
    }

    public function behaviors() {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort',
            ],
        ];
    }

    public function rules() {
        return [
            [['image', 'title'], 'required'],
            [['image', 'title'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['sort'], 'integer'],
            [['published'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['text_align', 'style'], 'string', 'max' => 25],
            [['style'], 'default', 'value' => 'bg-default'],
            [['lng'], 'string', 'max' => 5],
            [['lng'], 'default', 'value' => null],
            [['sorting', 'start_at', 'end_at'], 'safe'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Swiper::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Slider'),
            'title' => Yii::t('backend', 'Title'),
            'image' => Yii::t('backend', 'Image'),
            'content' => Yii::t('backend', 'Content'),
            'published' => Yii::t('backend', 'Published'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'text_align' => Yii::t('backend', 'Text Align'),
            'style' => Yii::t('backend', 'Style'),
            'lng' => Yii::t('backend', 'Language'),
            'start_at' => Yii::t('backend', 'Start Date'),
            'end_at' => Yii::t('backend', 'End Date'),
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            if ($this->start_at) {
                $this->start_at = Yii::$app->formatter->asTimestamp($this->start_at);
            } else {
                $this->start_at = time();
            }
            if ($this->end_at) {
                $this->end_at = Yii::$app->formatter->asTimestamp($this->end_at);
            } else {
                $this->end_at = null;
            }
        } else {
            if ($this->start_at) {
                $this->start_at = Yii::$app->formatter->asTimestamp($this->start_at);
            } else {
                $this->start_at = $this->getOldAttribute('start_at');
            }
            if ($this->end_at) {
                $this->end_at = Yii::$app->formatter->asTimestamp($this->end_at);
            } else {
                $this->end_at = $this->getOldAttribute('end_at');
            }
        }
        return parent::beforeSave($insert);
    }

    public function getSwiper() {
        return $this->hasOne(Swiper::className(), ['id' => 'item_id']);
    }

}