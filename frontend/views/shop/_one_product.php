<?php
/**
 * @var $product \frontend\models\ShopProducts
 */

use yii\bootstrap4\Html;
?>
<div class="product product-home2">
    <div class="js-product-thumbnail img-show">
        <?php foreach ($product->images as $image) { ?>
            <div class="product-image">
                <?= Html::a(Html::img($image->mediumImageUrl, ['alt' => $product->title, 'class' => 'img-fluid w-100']), ['/shop/product', 'alias' => $product->alias], ['title' => $product->title]) ?>
            </div>
        <?php } ?>
    </div>
    <div class="title">
        <?php if (count($product->images) > 1) { ?>
            <div class="slick-destop">
                <div class="js-slide-product slick-scoll">
                    <?php foreach ($product->images as $image) { ?>
                        <div class="product-image">
                            <?= Html::img($image->smallImageUrl, ['alt' => $product->title, 'class' => 'img-fluid w-100']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="information">
            <div class="type-shoes">
                <div><?= $product->category->title ?></div>
                <?php /*
                        <div>
                            <span><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star" style="color: #aaa;"></i><i class="fa fa-star" style="color: #aaa;"></i></span>
                            <span>(36)</span>
                        </div>
                        */ ?>
            </div>
            <?= Html::a('<h6>' . $product->title . '</h6>', ['/shop/product', 'alias' => $product->alias], ['title' => $product->title]) ?>
            <div class="type-code">
                <div><?= Yii::t('frontend', 'Code') . ': ' . $product->code ?></div>
            </div>
            <div class="dollar"><?= (($product->sale) ? Yii::$app->formatter->asCurrency($product->sale) . ' <span>' . Yii::$app->formatter->asCurrency($product->price) . '</span>' : Yii::$app->formatter->asCurrency($product->price)) ?></div>
        </div>
    </div>
    <?php if ($product->sale) { ?>
        <div class="sale"><?= Yii::$app->formatter->asPercent(($product->sale - $product->price)/$product->price) ?></div>
    <?php } ?>
    <?php if ($product->top) { ?>
        <div class="hot<?= (($product->sale) ? '-sale' : '') ?>">Hot</div>
    <?php } ?>
    <div class="option">
        <?= Html::a('<span><i class="fas fa-shopping-cart"></i></span>', ['/shop/cart/add'], ['class' => 'add-to-cart', 'data-id' => $product->id]) ?>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <?= Html::a('<span><i class="fas fa-heart"></i></span>', ['/user/wishlist/add'], ['class' => 'add-to-wish', 'data-id' => $product->id]) ?>
        <?php } ?>
    </div>
</div>