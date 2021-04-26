<?php
namespace frontend\models;

use common\models\Categories as BaseCategories;
use creocoder\nestedsets\NestedSetsBehavior;
use frontend\components\behaviors\NestedSetsTreeBehavior;

class Categories extends BaseCategories
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::class
            ],
        ];
    }

}