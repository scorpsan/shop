<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property int $id
 * @property int $frequency
 * @property string $name
 *
 * @property-read mixed $shopTags
 */
class Tags extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['frequency', 'name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'frequency' => Yii::t('backend', 'Frequency'),
            'name' => Yii::t('backend', 'Name'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getShopTags(): ActiveQuery
    {
        return $this->hasMany(ShopTags::class, ['tag_id' => 'id']);
    }

}