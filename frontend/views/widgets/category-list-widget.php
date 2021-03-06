<?php
/**
 * @var $items \frontend\models\ShopProducts
 * @var $params array
 * @var $options array
 */

use yii\helpers\Url;
use yii\web\View;

$itemClass = '';
switch ($options['count']) {
    case 1:
        $itemClass = 'col-12';
        break;
    case 2:
        $itemClass = 'col-xl-6 col-lg-6 col-md-6 col-12';
        break;
    case 3:
        $itemClass = 'col-xl-4 col-lg-4 col-md-6 col-12';
        break;
    default:
        $itemClass = 'col-xl-3 col-lg-3 col-md-6 col-12';
}
?>
<!-- Category List Widget -->
<section class="section-banner-v1-page2 <?= $params['style'] ?>">
    <div class="my-container mw-100">
        <?php if ($params['show_title']) { ?>
            <div class="section-title">
                <h2><?= $params['title'] ?></h2>
            </div>
        <?php } ?>
        <div class="row no-gutters">
            <?php foreach ($items as $key => $item) { ?>
                <?php if (!empty($item->translate->breadbg)) { ?>
                    <div class="category-item <?= $itemClass ?>">
                        <div class="banner banner01 relative image-effect">
                            <a href="<?= Url::to(['/shop/category', 'categoryalias' => $item->alias]) ?>" title="<?= $item->title ?>">
                                <div class="category-img" style="background-image:url(<?= $item->translate->breadbg ?>);"></div>
                                <div class="title absolute w-100 text-center">
                                    <h3 class="m-0 heading-3 font-weight-bold"><?= $item->title ?></h3>
                                    <p class="para-fs30 m-0">&nbsp;</p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="category-item <?= $itemClass ?>" style="background: #f4f4f4; overflow: hidden;">
                        <div class="banner banner03 text-center relative">
                            <div class="title absolute">
                                <h3 class="heading-3 font-weight-bold"><?= $item->title ?></h3>
                                <p class="para-fs18">&nbsp;</p>
                                <a href="<?= Url::to(['/shop/category', 'categoryalias' => $item->alias]) ?>" class="btn-shop-now"><?= Yii::t('frontend', 'Choose') ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

<!--
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="banner02 relative image-effect">
                    <a href="grid-slidebar-left.html">
                        <img src="/files/main.jpg" alt="_img banner Homepage 2" class="img-fluid w-100">
                    </a>
                    <div class="title absolute">
                        <p class="para-fs30 m-0">
                            Women's Training
                        </p>
                        <h3 class="heading-3 text-capitalize font-weight-bold">New Collection</h3>
                        <h6 class="para-fs30 text-capitalize font-weight-bold">Best Sellers</h6>
                        <a href="grid-slidebar-left.html" class="btn-shop-now">Shop now</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4" style="background: #f4f4f4; overflow: hidden;">
                <div class="banner03 text-center relative ">
                    <div class="title absolute">
                        <h6 class="para-fs30 font-weight-bold">Hello Summer 2019</h6>
                        <h3 class="heading-3 font-weight-bold">Extra 50%Off</h3>
                        <p class="para-fs18">It is a long established fact that a reader will
                            be distracted by the readable content of a page when
                            looking at its layout.</p>
                        <a href="grid-slidebar-left.html" class="btn-shop-now">Shop now</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="banner03 relative text-center image-effect">
                    <a href="grid-slidebar-left.html">
                        <img src="/files/main.jpg" alt="_img banner Homepage v2" class="img-fluid w-100">
                    </a>
                    <div class="title absolute w-100">
                        <p class="para-fs30 m-0 text-capitalize">Gina Dress</p>
                        <h3 class="heading-3 font-weight-bold text-capitalize">Collection 2019</h3>
                    </div>
                </div>
            </div>
-->
        </div>
    </div>
</section>
<!-- End Category List Widget -->
<?php
$this->registerJs('
    $(".section-banner-v1-page2 .category-item").each(function(){
        var highestBox = 0;
        $(".category-item .banner", this).each(function(){
            console.log($(this).height());
            if($(this).height() > highestBox) {
                highestBox = $(this).height();
            }
        });
        $(".category-item .banner", this).height(highestBox);
    });',
    View::POS_READY);
?>