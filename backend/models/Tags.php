<?php
namespace backend\models;

use yii\db\ActiveRecord;
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
    public static function tableName()
    {
        return '{{%tags}}';
    }

    public function rules()
    {
        return [
            [['frequency', 'name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'frequency' => Yii::t('backend', 'Frequency'),
            'name' => Yii::t('backend', 'Name'),
        ];
    }

    public function getShopTags()
    {
        return $this->hasMany(ShopTags::class, ['tag_id' => 'id']);
    }

}