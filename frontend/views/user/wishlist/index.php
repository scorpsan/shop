<?php
/**
 * @var View          $this
 * @var \frontend\models\UserWishlistItems $wishlist
 */

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'My Wish List');
?>
<section class="section-account p-0 m-0">
    <div class="my-container">
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $this->render('../profile/_menu') ?>
        </div>
        <span class="button-filter fas fa-ellipsis-v js-filter d-lg-none"></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $this->render('../profile/_menu') ?>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 category-right">
                <?php
                $breadcrumbs[] = ['label' => Yii::t('frontend', 'My Account'), 'url' => ['/user/profile/index']];
                $breadcrumbs[] = $this->title;
                ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                    'tag' => 'div',
                    'options' => ['class' => 'product-toolbar'],
                    'itemTemplate' => '{link} / ',
                    'activeItemTemplate' => '<span>{link}</span>',
                ]); ?>

                <?= $this->render('../shared/_alert') ?>

                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="font-weight-bold"><?= Html::encode($this->title) ?></h3>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <?php Pjax::begin(['id'=> 'wish-pjax','enablePushState' => false]); ?>
                            <div class="table-responsive mb-30">
                                <table class="table table-hover black-text">
                                    <thead>
                                        <tr>
                                            <th class="font-300 fz-18" colspan="2"><?= Yii::t('frontend', 'Product') ?></th>
                                            <th class="text-center font-300 fz-18"><?= Yii::t('frontend', 'Price') ?></th>
                                            <th class="text-center font-300 fz-18" colspan="2"><?= Yii::t('frontend', 'Action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wishlist as $item) { ?>
                                            <?php $product = $item->product; ?>
                                            <tr>
                                                <td><?= Html::img($product->smallImageMain, ['alt' => $product->title, 'class' => 'img-fluid', 'width' => '100', 'height' => '100']) ?></td>
                                                <td><?= Html::a($product->title, ['/shop/product', 'categoryalias' => ($product->category->depth > 0) ? $product->category->alias : null, 'alias' => $product->alias], ['title' => $product->title]) ?></td>
                                                <td class="text-center dollar"><?= (($product->sale) ? Yii::$app->formatter->asCurrency($product->sale) . '<br><span>' . Yii::$app->formatter->asCurrency($product->price) . '</span>' : Yii::$app->formatter->asCurrency($product->price)) ?></td>
                                                <td class="text-center wish-actions">
                                                    <?= Html::a('<i class="fas fa-cart-arrow-down" aria-hidden="true"></i>', ['to-cart'], ['class' => 'from-wish-to-cart', 'data-id' => $product->id]) ?>
                                                    <?= Html::a('<i class="fas fa-trash" aria-hidden="true"></i>', ['delete'], ['class' => 'delete-from-wish remove', 'data-id' => $product->id]) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>