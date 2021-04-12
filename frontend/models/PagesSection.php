<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class PagesSection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%pages_section}}';
    }

}