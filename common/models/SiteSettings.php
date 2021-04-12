<?php
namespace common\models;

use yii\db\ActiveRecord;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * Class SiteSettings
 * @package common\models
 *
 * @property int $id [int(11)]
 * @property string $phone [varchar(21)]
 * @property string $currency_code [varchar(3)]
 * @property string $admin_email [varchar(255)]
 * @property string $support_email [varchar(255)]
 * @property string $sender_email [varchar(255)]
 * @property string $contact_phone [varchar(255)]
 * @property string $viber_phone [varchar(21)]
 * @property string $whatsapp_phone [varchar(21)]
 * @property string $telegram_nick [varchar(255)]
 * @property string $skype_nick [varchar(255)]
 * @property float $long_map [float]
 * @property float $lat_map [float]
 * @property string $instagram_token [varchar(255)]
 * @property string $link_to_facebook [varchar(255)]
 * @property string $link_to_youtube [varchar(255)]
 * @property string $link_to_vk [varchar(255)]
 * @property string $link_to_pinterest [varchar(255)]
 * @property string $link_to_twitter [varchar(255)]
 * @property string $link_to_instagram [varchar(255)]
 * @property bool $coming_soon [tinyint(1)]
 * @property bool $search_on_site [tinyint(1)]
 * @property bool $shop_on_site [tinyint(1)]
 *
 * @property-read mixed $title
 * @property-read mixed $seotitle
 * @property-read mixed $keywords
 * @property-read mixed $description
 * @property-read ActiveQuery $translate
 * @property-read ActiveQuery $translates
 */
class SiteSettings extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%settings}}';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->translate->title;
    }

    /**
     * @return string
     */
    public function getSeotitle(): string
    {
        return $this->translate->seotitle;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->translate->keywords;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->translate->description;
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate(): ActiveQuery
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(SiteSettingsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(SiteSettingsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}