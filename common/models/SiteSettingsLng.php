<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class SiteSettingsLng
 * @package common\models
 *
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $lng [varchar(5)]
 * @property string $title [varchar(255)]
 * @property string $seotitle [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $address [varchar(255)]
 * @property string $about_footer
 * @property string $opening_hours [varchar(255)]
 * @property string $opening_hours_full [varchar(255)]
 * @property string $contact_info
 * @property string $address_map [varchar(255)]
 */
class SiteSettingsLng extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%settings_lng}}';
    }

}