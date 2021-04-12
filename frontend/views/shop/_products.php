<?php
/**
 * @var $items \frontend\models\ShopProducts
 * @var $pages \yii\data\Pagination
 */

use yii\widgets\LinkPager;
?>
<div class="select-option">
    <div class="text"><?= Yii::t('frontend', 'Show') . ' ' . ($pages->offset + 1) . ((($pages->offset + 1) != $pages->totalCount)?'-'.((($pages->offset + $pages->pageSize) > $pages->totalCount)?$pages->totalCount:($pages->offset + $pages->pageSize)):'') . ' ' . Yii::t('frontend', 'of') . ' ' . $pages->totalCount . ' ' . Yii::t('frontend', 'results') ?></div>
    <?php /*
    <div class="d-flex justify-content-end">
        <div class="select d-flex">
            <div class="select-sorting relative">
                <select name="page" id="page" class="page">
                    <option value="Filters">Filters </option>
                    <option>Featured</option>
                    <option>Best Selling</option>
                    <option>Alphabetically, A-Z</option>
                    <option>Alphabetically, Z-A</option>
                    <option>Price, low to high</option>
                    <option>Price, high to low</option>
                    <option>Date, new to old</option>
                    <option>Date, old to new</option>
                </select>
            </div>
        </div>
    </div> */
    ?>
</div>
<div class="row">
    <?= $this->render('../layouts/_alert') ?>

    <?php foreach ($items as $product) { ?>
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6 col-6">
        <?= $this->render('_one_product', ['product' => $product]) ?>
    </div>
    <?php } ?>
</div>
<?php if ($pages->getPageCount() > 1) { ?>
    <div class="section-next-page">
        <div class="my-container">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination content d-flex justify-content-center'],
                'pageCssClass' => 'arrow',
                'maxButtonCount' => 5,
                'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
                'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
                'firstPageLabel' => '<i class="fas fa-arrow-left"></i>',
                'lastPageLabel' => '<i class="fas fa-arrow-right"></i>',
                'firstPageCssClass' => 'first-arrow arrow',
                'lastPageCssClass' => 'last-arrow arrow',
                'prevPageCssClass' => 'prev-arrow arrow',
                'nextPageCssClass' => 'next-arrow arrow',
                'disableCurrentPageButton' => true,
            ]) ?>
        </div>
    </div>
<?php } ?>