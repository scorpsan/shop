<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => [
                ['label' => Yii::t('backend', 'Main'), 'options' => ['class' => 'header']],
                ['label' => Yii::t('backend', 'Dashboard'), 'icon' => 'dashboard', 'url' => ['/site/index'], 'active' => $this->context->id == 'site/index'],
                ['label' => Yii::t('backend', 'Shop'), 'options' => ['class' => 'header']],
                ['label' => 'Orders', 'icon' => 'file-o', 'url' => ['/shop/order/index'], 'active' => $this->context->id == 'shop/order'],
                ['label' => 'Products', 'icon' => 'file-o', 'url' => ['/shop/product/index'], 'active' => $this->context->id == 'shop/product'],
                ['label' => 'Brands', 'icon' => 'file-o', 'url' => ['/shop/brand/index'], 'active' => $this->context->id == 'shop/brand'],
                ['label' => 'Tags', 'icon' => 'file-o', 'url' => ['/shop/tag/index'], 'active' => $this->context->id == 'shop/tag'],
                ['label' => 'Categories', 'icon' => 'file-o', 'url' => ['/shop/category/index'], 'active' => $this->context->id == 'shop/category'],
                ['label' => 'Characteristics', 'icon' => 'file-o', 'url' => ['/shop/characteristic/index'], 'active' => $this->context->id == 'shop/characteristic'],
                ['label' => 'Delivery Methods', 'icon' => 'file-o', 'url' => ['/shop/delivery/index'], 'active' => $this->context->id == 'shop/delivery'],
                ['label' => Yii::t('backend', 'Reviews'), 'icon' => 'comment-o', 'url' => ['/testimonials/index'], 'active' => $this->context->id == 'testimonials'],

                ['label' => Yii::t('backend', 'Pages'), 'icon' => 'file-text', 'url' => '#', 'items' => [
                    ['label' => Yii::t('backend', 'Categories'), 'url' => ['/pages-categories/index'], 'active' => $this->context->id == 'pages-categories'],
                    ['label' => Yii::t('backend', 'Pages'), 'url' => ['/pages/index'], 'active' => $this->context->id == 'pages'],
                ]],
                ['label' => Yii::t('backend', 'Posts'), 'icon' => 'newspaper-o', 'url' => '#', 'items' => [
                    ['label' => Yii::t('backend', 'Categories'), 'url' => ['/posts-categories/index'], 'active' => $this->context->id == 'posts-categories'],
                    ['label' => Yii::t('backend', 'Posts'), 'url' => ['/posts/index'], 'active' => $this->context->id == 'posts'],
                ]],

                ['label' => Yii::t('backend', 'Components'), 'options' => ['class' => 'header']],
                ['label' => Yii::t('backend', 'Site Menu'), 'icon' => 'sitemap', 'url' => ['/menus/index'], 'active' => $this->context->id == 'menus'],
                ['label' => Yii::t('backend', 'Sliders'), 'icon' => 'picture-o', 'url' => ['/swiper/index'], 'active' => $this->context->id == 'swiper'],
                ['label' => Yii::t('backend', 'Partners'), 'icon' => 'th-list', 'url' => ['/partners/index'], 'active' => $this->context->id == 'partners'],
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

                ['label' => Yii::t('backend', 'Other'), 'options' => ['class' => 'header']],

                ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => 'admin', 'active' => $this->context->id == 'gii'],
                ['label' => 'Debug', 'icon' => 'tachometer', 'url' => ['/debug'], 'visible' => 'admin', 'active' => $this->context->id == 'debug'],

            ],
        ]) ?>
    </section>
</aside>