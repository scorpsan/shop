<?php
namespace backend\models;

use Yii;
/**
 * This is the model class for table "{{%posts_tags}}".
 *
 * @property int $item_id
 * @property int $tag_id
 *
 * @property ShopProducts $item
 * @property Tags $tag
 */
class ShopTags extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%shop_tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['item_id', 'tag_id'], 'required'],
            [['item_id', 'tag_id'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'item_id' => Yii::t('backend', 'Item ID'),
            'tag_id' => Yii::t('backend', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem() {
        return $this->hasOne(ShopProducts::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag() {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }

}