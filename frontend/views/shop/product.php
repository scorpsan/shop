<?php
/**
 * @var $product \frontend\models\ShopProducts
 * @var $categoryParent \frontend\models\Categories
 */

use frontend\widgets\FilterWidget;
use frontend\widgets\ProductsWidget;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

if (count($categoryParent)) {
    foreach ($categoryParent as $parent) {
        if ($parent->depth == 0)
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/shop/index']];
        if ($parent->depth == 1 || count($categoryParent) == 1)
            $this->params['breadcrumbs'][] = $parent->title;
    }
} else {
    $this->params['breadcrumbs'][] = $product->category->title;
}

$filter = FilterWidget::widget(['menu' => 'shop', 'brands' => true, 'tags' => true, 'categoryalias' => $product->category->alias]);
?>
<section class="section-product section-product-detail-v3">
    <div class="my-container">
        <?php if ($product->translate->seo_text) { ?>
            <div style="height:0px;overflow:hidden">
                <?= $product->translate->seo_text ?>
            </div>
        <?php } ?>
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
            <div class="col-xl-9 col-lg-9 col-md-12 category-right">
                <?php
                if (count($categoryParent)) {
                    foreach ($categoryParent as $parent) {
                        if ($parent->depth == 0)
                            $breadcrumbs[] = ['label' => $parent->title, 'url' => ['/shop/index']];
                        else
                            $breadcrumbs[] = ['label' => $parent->title, 'url' => ['/shop/category', 'categoryalias' => $parent->alias]];
                    }
                }
                if ($product->category->depth == 0)
                    $breadcrumbs[] = ['label' => $product->category->title, 'url' => ['/shop/index']];
                else
                    $breadcrumbs[] = ['label' => $product->category->title, 'url' => ['/shop/category', 'categoryalias' => $product->category->alias]];
                $breadcrumbs[] = $product->title;
                ?>
                <?= Breadcrumbs::widget([
                    'homeLink' => false,
                    'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                    'tag' => 'div',
                    'options' => ['class' => 'product-toolbar'],
                    'itemTemplate' => '{link} / ',
                    'activeItemTemplate' => '<span>{link}</span>',
                ]); ?>

                <?= $this->render('../layouts/_alert') ?>

                <div class="product-right-v1">
                    <div class="row">
                        <?php if (count($product->images)) { ?>
                        <div class="col-54">
                            <div class="js-product-thumbnail1 img-show">
                                <?php foreach ($product->images as $image) { ?>
                                    <div class="product-image">
                                        <?= Html::img($image->imageUrl, ['alt' => $product->title, 'class' => 'img-fluid']) ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (count($product->images) > 1) { ?>
                            <div class="js-slide-product1 slick-scoll">
                                <?php foreach ($product->images as $image) { ?>
                                    <div class="product-image">
                                        <?= Html::img($image->smallImageUrl, ['alt' => $product->title, 'class' => 'img-fluid']) ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="col-46">
                            <div class="info-product">
                                <div class="rating d-flex  align-items-center">
                                    <div><?= $product->brand->title ?></div>
                                    <?php /*
                                    <div>
                                        <span><i class="fa fa-star" style="color: #222"></i><i class="fa fa-star" style="color: #222"></i><i class="fa fa-star" style="color: #222"></i><i class="fa fa-star" style="color: #aaa"></i><i class="fa fa-star" style="color: #aaa"></i></span>
                                        <span>(150)</span>
                                    </div>
                                    */ ?>
                                </div>
                                <h4 class="name-product font-weight-bold"><?= $product->title ?></h4>
                                <div class="type-code">
                                    <div><?= Yii::t('frontend', 'Code') . ': ' . $product->code ?></div>
                                </div>
                                <h4 class="price-product">
                                    <?php if ($product->in_stock) { ?>
                                        <?= (($product->sale) ? Yii::$app->formatter->asCurrency($product->sale) . ' <span>' . Yii::$app->formatter->asCurrency($product->price) . '</span>' : Yii::$app->formatter->asCurrency($product->price)) ?>
                                    <?php } else { ?>
                                        <?= Yii::t('frontend', 'Out of Stock') ?>
                                    <?php } ?>
                                </h4>
                                <p><?= $product->translate->short_content ?></p>
                            </div>
                            <?php if ($product->in_stock) { ?>
                                <?php ActiveForm::begin(['id' => 'addToCart', 'action' => ['/cart/add']]) ?>
                                <h4 class="heading-4 font-weight-bold d-block select-option-p2"><?= Yii::t('frontend', 'Quantity') ?></h4>
                                <div class="size-quanlity">
                                    <div>
                                        <div class="select-quanlity">
                                            <select name="quanlity" id="quanlity" class="page">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="select-buy">
                                        <?= Html::a(Yii::t('frontend', 'Add to cart'), ['/cart/add'], ['class' => 'add-to-cart', 'data-id' => $product->id]) ?>
                                        <?php if (!Yii::$app->user->isGuest) { ?>
                                            <?= Html::a('<i class="fas fa-heart"></i>', ['/user/wishlist/add'], ['class' => 'add-to-wish', 'data-id' => $product->id]) ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end() ?>
                            <?php } ?>
                            <div class="link-page">
                                <?php
                                $categoryLinks = array();
                                $tagLinks = array();
                                foreach ($product->tags as $tag) {
                                    $tagLinks[] = Html::a($tag->name, ['/shop/index', 'tag' => $tag->name]);
                                } ?>
                                <?php if (count($categoryLinks)) { ?>
                                <div>
                                    <label class="font-weight-bold mb-0"><?= Yii::t('frontend', 'Categories') ?>:</label>
                                    <?= implode(', ', $categoryLinks) ?>
                                </div>
                                <?php } ?>
                                <?php if (count($tagLinks)) { ?>
                                <div>
                                    <label class="font-weight-bold mb-0"><?= Yii::t('frontend', 'Tags') ?>:</label>
                                    <?= implode(', ', $tagLinks) ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-description">
                    <ul class="tabs d-flex justify-content-between col-xl-8 col-lg-10 col-md-8">
                        <?php if (!empty($product->translate->content)) { ?>
                        <li class="tabs-link current font-weight-bold" data-tab="tab-1"><?= Yii::t('frontend', 'Description') ?></li>
                        <?php } ?>
                        <li class="tabs-link <?= (!empty($product->translate->content))?'':'current' ?> font-weight-bold" data-tab="tab-2"><?= Yii::t('frontend', 'Additionals info') ?></li>
                        <?php /** <li class="tabs-link font-weight-bold" data-tab="tab-3"><?= Yii::t('frontend', 'Reviews') . '(1)' ?></li> */ ?>
                    </ul>
                    <?php if (!empty($product->translate->content)) { ?>
                    <div id="tab-1" class="tab-content current">
                        <?= $product->translate->content ?>
                    </div>
                    <?php } ?>
                    <div id="tab-2" class="tab-content <?= (!empty($product->translate->content))?'':'current' ?>">
                        <table class="table">
                            <tbody>
                            <?php
                            $charKeys = array_keys($product->characteristics->attributeLabels());
                            foreach ($charKeys as $key) {
                                if ($product->characteristics->$key) {
                                    echo '<tr><td>'.$product->characteristics->getAttributeLabel($key).'</td><td>'.$product->characteristics->$key . ' ' . $product->characteristics->getAttributeHint($key).'</td></tr>';
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php /**
                    <div id="tab-3" class="tab-content">
                        <div class="review">
                            <h3 class="text-center">1 review for Printed Maxi Dress</h3>
                            <div class="comment">
                                <div class="feedback d-flex">
                                    <img src="img/user.jpg" alt="_img user">
                                    <div class="comment-content">
                                        <div class="rating">
                                            <select class="select-rating d-none" name="rating" autocomplete="off"> <!-- now hidden -->
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="author-date d-flex">
                                            <strong>Admin</strong>-
                                            <div class="date">23.Sep.2019</div>
                                        </div>
                                        <div class="description">
                                            Great and cheap
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-review">
                                <h3>
                                    ADD A REVIEW
                                </h3>
                                <div class="review-note">
                                    Your email address will not be published. Required fields are marked
                                </div>
                                <div class="review-form">
                                    <form action="/action_page.php" method="POST">
                                        <div class="form-group w-75">
                                            <input type="text" id="author" name="author" class="form-control" placeholder="Name*" required>
                                        </div>
                                        <div class="form-group w-75">
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Email*" required>
                                        </div>
                                        <div class="rating-user">
                                            <label for="rating">Your rating</label>
                                            <select class="select-rating d-none" name="rating" autocomplete="off"> <!-- now hidden -->
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="review-content form-group">
                                            <textarea name="comment" id="comment" cols="30" rows="10" class="w-75" placeholder="Your comment here*"></textarea>
                                        </div>
                                        <button type="submit" name="submit" value="submit" class="btn-shop-now">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                */ ?>
                <?= ProductsWidget::widget(['options' => ['type' => 'rnd', 'count' => 3], 'params' => ['title' => Yii::t('frontend', 'You May Also Like'), 'tagTitle' => 3]]) ?>
                <?php // ProductsWidget::widget(['options' => ['type' => 'hit', 'count' => 3], 'params' => ['title' => Yii::t('frontend', 'Relates Products'), 'style' => 'bg-white margin-product p-0', 'tagTitle' => 3]]) ?>
            </div>
        </div>
    </div>
</section>
