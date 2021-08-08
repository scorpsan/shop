<?php
/**
 * @var $categoryalias $product->category->alias
 * @var $menu string
 * @var $secondMenu array
 * @var $brands array
 * @var $tags array
 */

use frontend\widgets\Menu;
use yii\bootstrap4\Html;

?>
<?php if (!empty($secondMenu)) { ?>
    <div class="row filter-product__first">
        <div class="col-12">
            <h4 class="heading-4"><?= Yii::t('frontend', 'Categories') ?></h4>
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
                'route' => ($categoryalias) ? $menu . '/category' : null,
                'params' => ($categoryalias) ? ['categoryalias' => $categoryalias] : null,
            ]); ?>
        </div>
    </div>
<?php } ?>
<?php if (!empty($brands)) { ?>
    <div class="row filter-brand">
        <div class="col-12">
            <h4 class="heading-4"><?= Yii::t('frontend', 'Brands') ?></h4>
            <?= Menu::widget([
                'items' => $brands,
                'options' => [
                    'class' => 'main-menu'
                ],
                'itemOptions' => [
                    'class' => 'item-menu'
                ],
                'linkTemplate' => '<a href="{url}" title="{title}" class="{class}">{label} <span class="font-weight-lighter">{count}</span></a>',
                'menuItemCssClass' => 'nav-link',
                'activeCssClass' => 'active',
            ]); ?>
        </div>
    </div>
<?php } ?>
<?php if (!empty($tags)) { ?>
    <div class="row filter-tag p-0">
        <div class="col-12">
            <h4 class="heading-4"><?= Yii::t('frontend', 'Product Tags') ?></h4>
            <ul class="list-tag d-flex flex-wrap">
                <?php foreach ($tags as $tag) { ?>
                <li class="item-tag">
                    <?= Html::a($tag->name, ['/shop/index', 'tag' => $tag->name]) ?>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>