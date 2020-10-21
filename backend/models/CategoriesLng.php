<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%categories_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $content
 * @property string $img
 */
class CategoriesLng extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%categories_lng}}';
    }

    public function rules() {
        return [
            [['item_id', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['content'], 'string'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'content' => Yii::t('backend', 'Content'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'img' => Yii::t('backend', 'Image'),
        ];
    }

}