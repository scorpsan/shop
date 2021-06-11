<?php
/**
 * @var $products \frontend\models\ShopProducts
 * @var $category \frontend\models\Categories
 * @var $categoryParent \frontend\models\Categories
 * @var $pages \yii\data\Pagination
 * @var $search string|null
 * @var $secondMenu \frontend\models\Categories
 * @var $brands \frontend\models\ShopBrands
 */

use frontend\widgets\FilterWidget;

$this->title = $category->title;

if (count($categoryParent)) {
    foreach ($categoryParent as $parent) {
        if ($parent->depth == 0)
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/shop/index']];
        else
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/shop/category', 'categoryalias' => $parent->alias]];
    }
}
$this->params['breadcrumbs'][] = $category->title;

$filter = FilterWidget::widget();
?>
<section class="section-product section-product-v1 p-0 m-0">
    <div class="my-container">
        <?php if ($category->translate->seo_text) { ?>
            <div style="height:0px;overflow:hidden">
                <?= $category->translate->seo_text ?>
            </div>
        <?php } ?>
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $filter ?>
        </div>
        <span class="button-filter fas fa-filter js-filter d-lg-none"></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $filter ?>
            </div>
            <div class="col-xl-9 col-lg-9">
                <?= $this->render('_products', ['items' => $products, 'pages' => $pages]) ?>
            </div>
        </div>
    </div>
</section>