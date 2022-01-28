<?php
namespace backend\models;

use common\models\SiteSettingsLng as BaseSiteSettingsLng;
use Yii;

class SiteSettingsLng extends BaseSiteSettingsLng
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['about_footer', 'contact_info'], 'string'],
            [['address', 'address_map', 'opening_hours', 'opening_hours_full', 'logo_b', 'logo_w', 'logo_footer'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => SiteSettings::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
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
            'logo_b' => Yii::t('backend', 'Logo Dark'),
            'logo_w' => Yii::t('backend', 'Logo Lite'),
            'logo_footer' => Yii::t('backend', 'Logo for Footer block'),
        ];
    }

}