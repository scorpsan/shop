<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property-read ActiveQuery $content
 *
 * @property int $id [int(11)]
 * @property int $item_id [int(11)]
 * @property string $lng [varchar(5)]
 * @property string $title [varchar(255)]
 * @property string $seotitle [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $seo_text
 * @property string $breadbg [varchar(255)]
 */
class PagesLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%pages_lng}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getContent() {
        return $this->hasMany(PagesSection::class, ['item_id' => 'id'])
            ->andWhere(['published' => true])->orderBy(['sort' => SORT_ASC]);
    }

}