<?php
namespace frontend\models;

use common\models\Pages as BasePages;

class Pages extends BasePages
{
    /**
     * @return Pages|null
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
     * @return Pages|null
     */
    public static function findAliasPage($alias)
    {
        return self::find()->where([
            'alias' => $alias,
            'published' => true,
        ])->with('translate')->limit(1)->one();
    }

}