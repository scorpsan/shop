<?php
/**
 * @var $posts \frontend\models\Posts
 * @var $category \frontend\models\Categories
 * @var $categoryParent \frontend\models\Categories
 * @var $pages \yii\data\Pagination
 */

use frontend\widgets\FilterWidget;

if (count($categoryParent)) {
    foreach ($categoryParent as $parent) {
        if ($parent->depth == 0)
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/posts/index']];
        else
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/posts/category', 'categoryalias' => $parent->alias]];
    }
}
$this->params['breadcrumbs'][] = $category->title;

$filter = FilterWidget::widget(['menu' => 'posts']);
?>
<section class="product-blog-v2">
    <div class="my-container column-right">
        <?php if ($category->translate->seo_text) { ?>
            <div style="height:0px;overflow:hidden">
                <?= $category->translate->seo_text ?>
            </div>
        <?php } ?>
        <?php if (!empty($filter)) { ?>
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $filter ?>
        </div>
        <span class="button-filter js-filter d-lg-none"><?= Yii::t('frontend', 'Categories') ?> / <?= Yii::t('frontend', 'Filter') ?></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $filter ?>
            </div>
            <div class="col-xl-9 col-lg-9">
        <?php } else { ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
        <?php } ?>
                <div class="bread-crumb"></div>
                <?= $this->render('_posts', ['items' => $posts, 'pages' => $pages]) ?>
            </div>
        </div>
    </div>
</section>