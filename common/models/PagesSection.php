<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $title [varchar(255)]
 * @property string $subtitle [varchar(255)]
 * @property string $precontent
 * @property string $id_section [varchar(255)]
 * @property bool $show_title [tinyint(1)]
 * @property bool $published [tinyint(1)]
 * @property string $style [varchar(100)]
 * @property string $text_align [varchar(25)]
 * @property string $background [varchar(255)]
 * @property bool $parallax [tinyint(1)]
 * @property int $sort [int(3)]
 * @property bool $widget [tinyint(1)]
 * @property string $widget_type [varchar(255)]
 * @property string $content
 */
class PagesSection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%pages_section}}';
    }

}