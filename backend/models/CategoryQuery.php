<?php
namespace backend\models;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * Class CategoryQuery
 *
 * @see Categories
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }

}