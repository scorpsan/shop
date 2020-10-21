<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => [
                ['label' => Yii::t('backend', 'Main'), 'options' => ['class' => 'header']],
                ['label' => Yii::t('backend', 'Dashboard'), 'icon' => 'dashboard', 'url' => ['/site/index']],
                ['label' => Yii::t('backend', 'Site Menu'), 'icon' => 'sitemap', 'url' => ['/menus/index']],
                ['label' => Yii::t('backend', 'Pages'), 'icon' => 'file-text', 'url' => '#', 'items' => [
                    ['label' => Yii::t('backend', 'Categories'), 'url' => ['/pages-categories/index']],
                    ['label' => Yii::t('backend', 'Pages'), 'url' => ['/pages/index']],
                ]],
                ['label' => Yii::t('backend', 'Posts'), 'icon' => 'newspaper-o', 'url' => '#', 'items' => [
                    ['label' => Yii::t('backend', 'Categories'), 'url' => ['/posts-categories/index']],
                    ['label' => Yii::t('backend', 'Posts'), 'url' => ['/posts/index']],
                ]],
                ['label' => Yii::t('backend', 'Portfolio'), 'icon' => 'suitcase', 'url' => '#', 'items' => [
                    ['label' => Yii::t('backend', 'Categories'), 'url' => ['/portfolio-categories/index']],
                    ['label' => Yii::t('backend', 'Portfolio'), 'url' => ['/portfolio/index']],
                ]],
                ['label' => Yii::t('backend', 'Reviews'), 'icon' => 'comment-o', 'url' => ['/testimonials/index']],

                ['label' => Yii::t('backend', 'Components'), 'options' => ['class' => 'header']],
                ['label' => Yii::t('backend', 'Sliders'), 'icon' => 'picture-o', 'url' => ['/swiper/index']],
                ['label' => Yii::t('backend', 'Partners'), 'icon' => 'th-list', 'url' => ['/partners/index']],
                ['label' => Yii::t('backend', 'Comments'), 'icon' => 'comments-o', 'url' => ['/comments/index']],

                ['label' => Yii::t('backend', 'Settings'), 'options' => ['class' => 'header']],

                ['label' => Yii::t('backend', 'Users'), 'icon' => 'users', 'url' => '#', 'visible' => 'manager', 'items' => [
                    ['label' => Yii::t('backend', 'Users'), 'url' => ['/user/admin/index'], 'visible' => 'manager'],
                    ['label' => Yii::t('backend', 'Roles'), 'url' => ['/user/role/index'], 'visible' => 'admin'],
                    ['label' => Yii::t('backend', 'Permissions'), 'url' => ['/user/permission/index'], 'visible' => 'admin'],
                    ['label' => Yii::t('backend', 'Rules'), 'url' => ['/user/rule/index'], 'visible' => 'admin'],
                ]],
                ['label' => Yii::t('backend', 'Languages'), 'icon' => 'language', 'url' => ['/language/index']],
                ['label' => Yii::t('backend', 'Site settings'), 'icon' => 'cogs', 'url' => ['/site-settings/index']],

                ['label' => Yii::t('backend', 'Other'), 'options' => ['class' => 'header']],

                ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => 'admin'],
                ['label' => 'Debug', 'icon' => 'tachometer', 'url' => ['/debug'], 'visible' => 'admin'],

            ],
        ]) ?>
    </section>
</aside>