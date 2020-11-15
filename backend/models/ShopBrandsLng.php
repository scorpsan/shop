<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shop_brands_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $content
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $seo_text
 */
class ShopBrandsLng extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%shop_brands_lng}}';
    }

    public function rules() {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['content', 'seo_text'], 'string'],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopBrands::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'content' => Yii::t('backend', 'Content'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'SEO Text'),
        ];
    }

}