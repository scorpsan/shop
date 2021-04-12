<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class CategoriesLng extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%categories_lng}}';
    }

}