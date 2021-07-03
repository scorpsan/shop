<?php
namespace backend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%queue}}".
 *
 * @property int $id
 * @property string $channel
 * @property resource $job
 * @property int $pushed_at
 * @property int $ttr
 * @property int $delay
 * @property int $priority
 * @property int|null $reserved_at
 * @property int|null $attempt
 * @property int|null $done_at
 */
class Queue extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%queue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['channel', 'job', 'pushed_at', 'ttr'], 'required'],
            [['job'], 'string'],
            [['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at'], 'integer'],
            [['channel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'channel' => Yii::t('backend', 'Channel'),
            'job' => Yii::t('backend', 'Job'),
            'pushed_at' => Yii::t('backend', 'Pushed At'),
            'ttr' => Yii::t('backend', 'Ttr'),
            'delay' => Yii::t('backend', 'Delay'),
            'priority' => Yii::t('backend', 'Priority'),
            'reserved_at' => Yii::t('backend', 'Reserved At'),
            'attempt' => Yii::t('backend', 'Attempt'),
            'done_at' => Yii::t('backend', 'Done At'),
        ];
    }
}
