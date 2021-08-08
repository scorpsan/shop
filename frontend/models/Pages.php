<?php
namespace frontend\models;

use common\models\Pages as BasePages;
use yii\db\ActiveRecord;

class Pages extends BasePages
{
    /**
     * @return ActiveRecord|null
     */
    public static function findIndexPage()
    {
        return self::find()->where([
            'main' => true,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

    /**
     * @param $alias
     * @return ActiveRecord|null
     */
    public static function findAliasPage($alias)
    {
        return self::find()->where([
            'alias' => $alias,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

}