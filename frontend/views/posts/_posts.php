<?php
/**
 * @var $items \frontend\models\Posts
 * @var $pages \yii\data\Pagination
 */

use yii\widgets\LinkPager;
?>
<div class="row">
    <?= $this->render('../layouts/_alert') ?>

    <?php foreach ($items as $post) { ?>
    <div class="col-xl-6 col-lg-6 col-md-6">
        <?= $this->render('_one_post', ['post' => $post]) ?>
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