<?php
namespace backend\models;

use common\models\SiteSettingsLng as BaseSiteSettingsLng;
use Yii;

/**
 * This is the model class for table "{{%settings_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $address
 * @property string $about_footer
 * @property string $opening_hours
 * @property string $opening_hours_full
 * @property string $contact_info
 * @property string $address_map
 */
class SiteSettingsLng extends BaseSiteSettingsLng {

    public function rules() {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['about_footer', 'contact_info'], 'string'],
            [['address', 'address_map', 'opening_hours', 'opening_hours_full'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => SiteSettings::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'App Name / Title'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'address' => Yii::t('backend', 'Address'),
            'about_footer' => Yii::t('backend', 'Footer About Text'),
            'opening_hours' => Yii::t('backend', 'Opening Hours'),
            'opening_hours_full' => Yii::t('backend', 'Opening Hours Full'),
            'contact_info' => Yii::t('backend', 'Requisites'),
            'address_map' => Yii::t('backend', 'Address on Map'),
        ];
    }

}