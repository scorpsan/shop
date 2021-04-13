<?php
use frontend\widgets\Menu;

$secondMenu = [
    [ 'label' => Yii::t('frontend', 'My Profile'), 'url' => ['/user/profile/index']],
    [ 'label' => Yii::t('frontend', 'My Orders'), 'url' => ['/user/profile/orders']],
    [ 'label' => Yii::t('frontend', 'My Wish List'), 'url' => ['/user/wishlist/index']],
    [ 'label' => Yii::t('frontend', 'Sign Out'), 'url' => ['/user/security/logout'], 'template' => '<a href="{url}" title="{title}" class="{class}" data-method="post">{label}</a>'],
];
?>
<div class="row filter-submenu">
    <div class="col-12">
        <h4 class="heading-4"><?= Yii::t('frontend', 'My Account') ?></h4>
        <?= Menu::widget([
            'items' => $secondMenu,
            'options' => [
                'class' => 'main-menu'
            ],
            'itemOptions' => [
                'class' => 'item-menu'
            ],
            'submenuTemplate' => '<div class="submenu"><ul>{items}</ul></div>',
            'shevronSubmenu' => '<span class="fas fa-chevron-right down"></span>',
            'subMenuItemCssClass' => 'sliderdown d-flex justify-content-between align-items-center',
            'activateParents' => false,
            'activeCssClass' => 'active',
        ]); ?>
    </div>
</div>