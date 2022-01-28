<?php
namespace backend\models;

use common\models\SiteSettings as BaseSiteSettings;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property-read ActiveQuery $translates
 */
class SiteSettings extends BaseSiteSettings
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['phone', 'admin_email', 'support_email', 'sender_email', 'currency_code'], 'required'],
            [['currency_code'], 'string', 'max' => 3],
            [['admin_email', 'support_email', 'sender_email'], 'email'],
            [['phone', 'viber_phone', 'whatsapp_phone',], 'string', 'max' => 21],
            [['contact_phone', 'telegram_nick', 'skype_nick', 'instagram_token', 'link_to_facebook', 'link_to_youtube', 'link_to_vk', 'link_to_pinterest', 'link_to_twitter', 'link_to_instagram'], 'string', 'max' => 255],
            [['long_map', 'lat_map'], 'number'],
            [['coming_soon'], 'boolean'],
            [['coming_soon'], 'default', 'value' => false],
            [['custom_style'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'phone' => Yii::t('backend', 'Top Phone Number'),
            'currency_code' => Yii::t('backend', 'Currency Code'),
            'admin_email' => Yii::t('backend', 'Administrator Email'),
            'support_email' => Yii::t('backend', 'Support Email'),
            'sender_email' => Yii::t('backend', 'Sender Email'),
            'contact_phone' => Yii::t('backend', 'List of contact phones (one row - one number)'),
            'viber_phone' => Yii::t('backend', 'Viber Phone Number'),
            'whatsapp_phone' => Yii::t('backend', 'WhatsApp Phone Number'),
            'telegram_nick' => Yii::t('backend', 'Telegram NickName'),
            'skype_nick' => Yii::t('backend', 'Skype NickName'),
            'long_map' => Yii::t('backend', 'Longitude Map Data (X)'),
            'lat_map' => Yii::t('backend', 'Latitude Map Data (Y)'),
            'instagram_token' => Yii::t('backend', 'Instagram Token'),
            'link_to_facebook' => Yii::t('backend', 'Link to Facebook'),
            'link_to_youtube' => Yii::t('backend', 'Link to YouTube'),
            'link_to_vk' => Yii::t('backend', 'Link to Vk'),
            'link_to_pinterest' => Yii::t('backend', 'Link to Pinterest'),
            'link_to_twitter' => Yii::t('backend', 'Link to Twitter'),
            'link_to_instagram' => Yii::t('backend', 'Link to Instagram'),
            'custom_style' => Yii::t('backend', 'Custome CSS Style'),
            'coming_soon' => Yii::t('backend', 'This Site is Coming Soon'),
            'search_on_site' => Yii::t('backend', 'Search on Site on/off'),
            'shop_on_site' => Yii::t('backend', 'Shop on Site on/off'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(SiteSettingsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}