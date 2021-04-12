<?php
namespace frontend\models;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * Class MenusQuery
 * @package frontend\models
 */
class MenusQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }

}