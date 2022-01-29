<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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