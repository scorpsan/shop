<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => [
                ['label' => Yii::t('backend', 'Main'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend', 'Dashboard'), 'icon' => 'dashboard', 'url' => ['/site/index'], 'active' => $this->context->id == 'site/index'],

                ['label' => Yii::t('backend', 'Shop'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend','Orders'), 'icon' => 'shopping-basket', 'url' => ['/shop/orders/index'], 'active' => $this->context->id == 'shop/orders'],
                    ['label' => Yii::t('backend', 'Categories'), 'icon' => 'folder-open-o', 'url' => ['/shop/categories/index'], 'active' => $this->context->id == 'shop/categories'],
                    ['label' => Yii::t('backend', 'Products'), 'icon' => 'cubes', 'url' => ['/shop/product/index'], 'active' => $this->context->id == 'shop/product'],
                    ['label' => Yii::t('backend', 'Brands'), 'icon' => 'th-list', 'url' => ['/shop/brand/index'], 'active' => $this->context->id == 'shop/brand'],
                    ['label' => Yii::t('backend', 'Tags'), 'icon' => 'tags', 'url' => ['/shop/tags/index'], 'active' => $this->context->id == 'shop/tags'],
                    ['label' => Yii::t('backend', 'Characteristics'), 'icon' => 'file-o', 'url' => ['/shop/characteristic/index'], 'active' => $this->context->id == 'shop/characteristic'],
                    ['label' => Yii::t('backend', 'Delivery Methods'), 'icon' => 'truck', 'url' => ['/shop/delivery/index'], 'active' => $this->context->id == 'shop/delivery'],
                    ['label' => Yii::t('backend', 'Payment Methods'), 'icon' => 'credit-card', 'url' => ['/shop/payment/index'], 'active' => $this->context->id == 'shop/payment'],
                    ['label' => Yii::t('backend', 'Reviews'), 'icon' => 'comment-o', 'url' => ['/testimonials/index'], 'active' => $this->context->id == 'testimonials'],

                ['label' => Yii::t('backend', 'Components'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend', 'Pages'), 'icon' => 'file-text', 'url' => '#', 'items' => [
                        ['label' => Yii::t('backend', 'Categories'), 'url' => ['/pages/categories/index'], 'active' => $this->context->id == 'pages/categories'],
                        ['label' => Yii::t('backend', 'Pages'), 'url' => ['/pages/page/index'], 'active' => $this->context->id == 'pages/page'],
                    ]],
                    ['label' => Yii::t('backend', 'Posts'), 'icon' => 'newspaper-o', 'url' => '#', 'items' => [
                        ['label' => Yii::t('backend', 'Categories'), 'url' => ['/posts/categories/index'], 'active' => $this->context->id == 'posts/categories'],
                        ['label' => Yii::t('backend', 'Posts'), 'url' => ['/posts/post/index'], 'active' => $this->context->id == 'posts/post'],
                    ]],
                    ['label' => Yii::t('backend', 'Site Menu'), 'icon' => 'sitemap', 'url' => ['/menus/index'], 'active' => $this->context->id == 'menus'],
                    ['label' => Yii::t('backend', 'Sliders'), 'icon' => 'picture-o', 'url' => ['/swiper/index'], 'active' => $this->context->id == 'swiper'],
                    ['label' => Yii::t('backend', 'Comments'), 'icon' => 'comments-o', 'url' => ['/comments/index'], 'active' => $this->context->id == 'comments'],

                ['label' => Yii::t('backend', 'Settings'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend', 'Users'), 'icon' => 'users', 'url' => '#', 'visible' => 'manager', 'items' => [
                        ['label' => Yii::t('backend', 'Users'), 'url' => ['/user/admin/index'], 'visible' => 'manager', 'active' => $this->context->id == 'user/admin'],
                        ['label' => Yii::t('backend', 'Roles'), 'url' => ['/user/role/index'], 'visible' => 'admin', 'active' => $this->context->id == 'user/role'],
                        ['label' => Yii::t('backend', 'Permissions'), 'url' => ['/user/permission/index'], 'visible' => 'admin', 'active' => $this->context->id == 'user/permission'],
                        ['label' => Yii::t('backend', 'Rules'), 'url' => ['/user/rule/index'], 'visible' => 'admin', 'active' => $this->context->id == 'user/rule'],
                    ]],
                    ['label' => Yii::t('backend', 'Languages'), 'icon' => 'language', 'url' => ['/language/index'], 'active' => $this->context->id == 'language'],
                    ['label' => Yii::t('backend', 'Site settings'), 'icon' => 'cogs', 'url' => ['/site-settings/index'], 'active' => $this->context->id == 'site-settings'],

                ['label' => Yii::t('backend', 'Other'), 'visible' => 'admin', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => 'admin', 'active' => $this->context->id == 'gii'],
                    ['label' => 'Debug', 'icon' => 'tachometer', 'url' => ['/debug'], 'visible' => 'admin', 'active' => $this->context->id == 'debug'],

            ],
        ]) ?>
    </section>
</aside>