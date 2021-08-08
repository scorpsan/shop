<?php
use yii\helpers\Url;

if (!empty($items->slides)) { ?>
<!-- Swiper-->
<section class="section-slide-v1 section-slide-v2">
    <div class="js-slick-slide-v2 slick-header-v2">
    <?php foreach ($items->slides as $slide) : ?>
        <div class="slider-child">
            <div class="img-slider">
                <img src="<?= Url::to('@web' . $slide->image) ?>" alt="<?= $slide->title ?>" class="img-fluid w-100">
            </div>
            <?php if (!empty($slide->content)) { ?>
            <div class="title <?= $slide->text_align ?>">
                <div class="my-container">
                    <?= $slide->content ?>
                </div>
            </div>
            <?php } ?>
        </div>
    <?php endforeach; ?>
    </div>
</section>
<?php } ?>
<?php /*
<section class="section-slide-v1 section-slide-v2">
    <div class="js-slick-slide-v2 slick-header-v2">
        <div class="slider-child">
            <div class="img-slider">
                <img src="img/page2_01.jpg" alt="_img-slider" class="img-fluid w-100">
            </div>
            <div class=" title">
                <div class="my-container">
                    <p class="sub-title m-0">Women's Originals</p>
                    <h1 class="mb-0">Coeeze Cropped Dresses.</h1>
                    <p class="content font-weight-bold">01 - Women/Clothing</p>
                    <a href="javascript:void(0)" class="btn-shop-now">Dicosvery Now</a>
                </div>
            </div>
        </div>
        <div class="slider-child">
            <div class="img-slider">
                <img src="img/page2_01-2.jpg" alt="_img-slider" class="img-fluid w-100">
            </div>
            <div class=" title">
                <div class="my-container">
                    <p class="sub-title m-0">Women's Originals</p>
                    <h1 class="mb-0">Coeeze Cropped Dresses.</h1>
                    <p class="content font-weight-bold">01 - Women/Clothing</p>
                    <a href="javascript:void(0)" class="btn-shop-now">Dicosvery Now</a>
                </div>
            </div>
        </div>
        <div class="slider-child">
            <div class="img-slider">
                <img src="img/page2_01-3.jpg" alt="_img-slider" class="img-fluid w-100">
            </div>
            <div class=" title">
                <div class="my-container">
                    <p class="sub-title m-0">Women's Originals</p>
                    <h1 class="mb-0">Coeeze Cropped Dresses.</h1>
                    <p class="content font-weight-bold">01 - Women/Clothing</p>
                    <a href="grid-slidebar-left.html" class="btn-shop-now">Dicosvery Now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="js-header-child-home2 slick-child-header-h2">
        <div class="item">
            <img src="img/page2_sick-child.jpg" alt="_img Homepage02 slick child header" class="img-fluid w-100">
        </div>
        <div class="item">
            <img src="img/page2_sick-child.jpg" alt="_img Homepage02 slick child header" class="img-fluid w-100">
        </div>
        <div class="item">
            <img src="img/page2_sick-child.jpg" alt="_img Homepage02 slick child header" class="img-fluid w-100">
        </div>
    </div>
</section>
*/ ?>