<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%pages_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $seo_text
 */
class PagesLng extends \yii\db\ActiveRecord {

    public $sections;

    public static function tableName() {
        return '{{%pages_lng}}';
    }

    public function rules() {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['seo_text'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'SEO Text'),
        ];
    }

    public function beforeDelete() {
        PagesSection::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public function getContent() {
        return $this->hasMany(PagesSection::className(), ['item_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

}