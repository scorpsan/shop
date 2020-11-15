<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shop_characteristics_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string|null $units
 * @property string|null $default
 */
class ShopCharacteristicsLng extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%shop_characteristics_lng}}';
    }

    public function rules() {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'default'], 'string', 'max' => 255],
            [['units'], 'string', 'max' => 10],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCharacteristics::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'units' => Yii::t('backend', 'Units'),
            'default' => Yii::t('backend', 'Default'),
        ];
    }

}