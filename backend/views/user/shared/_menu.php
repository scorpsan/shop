<?= \yii\bootstrap\Nav::widget(
    [
        'options' => [
            'class' => 'nav nav-tabs',
        ],
        'items' => [
            [
                'label' => Yii::t('usuario', 'Users'),
                'url' => ['/user/admin/index'],
            ],
            [
                'label' => Yii::t('usuario', 'Roles'),
                'url' => ['/user/role/index'],
            ],
            [
                'label' => Yii::t('usuario', 'Permissions'),
                'url' => ['/user/permission/index'],
            ],
            [
                'label' => Yii::t('usuario', 'Rules'),
                'url' => ['/user/rule/index'],
            ],
            [
                'label' => Yii::t('usuario', 'Create'),
                'items' => [
                    [
                        'label' => Yii::t('usuario', 'New user'),
                        'url' => ['/user/admin/create'],
                    ],
                    [
                        'label' => Yii::t('usuario', 'New role'),
                        'url' => ['/user/role/create'],
                    ],
                    [
                        'label' => Yii::t('usuario', 'New permission'),
                        'url' => ['/user/permission/create'],
                    ],
                    [
                        'label' => Yii::t('usuario', 'New rule'),
                        'url' => ['/user/rule/create'],
                    ],
                ],
            ],
        ],
    ]
) ?>
