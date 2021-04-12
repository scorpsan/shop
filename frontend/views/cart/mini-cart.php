<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $cartQty int
 */

use yii\helpers\Html;
use yii\helpers\Url;

$total = 0;
?>
<?php if ($cartQty) { ?>
    <div class="minicart-scroll-content">
    <?php foreach ($cartList as $key => $prod) {
        $price = (($productList[$key]->sale) ? $productList[$key]->sale : $productList[$key]->price);
        $totalPrice = $prod['qty'] * $price;
        $total += $totalPrice;
        ?>
        <ul class="minicart-item list-unstyled">
            <li class="product-cart">
                <?= Html::a(Html::img($productList[$key]->smallImageMain, ['alt' => $productList[$key]->title, 'class' => 'img-fluid']), ['/shop/product', 'categoryalias' => ($productList[$key]->category->depth > 0) ? $productList[$key]->category->alias : null, 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title, 'class' => 'product-image product-thumb-link', 'data-pjax' => 0]) ?>
                <div class="product-detail">
                    <h3 class="product-name">
                        <?= Html::a($productList[$key]->title, ['/shop/product', 'categoryalias' => ($productList[$key]->category->depth > 0) ? $productList[$key]->category->alias : null, 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title, 'data-pjax' => 0]) ?>
                    </h3>
                    <div class="product-detail-info">
                        <span class="product-quantity"><?= Yii::t('frontend', 'QTY') ?>: <?= $prod['qty'] ?></span>
                        <span class="product-price"><span class="product-price-symbol"></span><?= Yii::$app->formatter->asCurrency($price) ?></span>
                        <div class="product-remove float-right">
                            <span class="delete-from-cart remove-product" data-url="<?= Url::to(['/cart/delete']) ?>" data-id="<?= $key ?>"><i class="fas fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    <?php } ?>
    </div>
    <div class="subtotal-actions">
        <div class="subtotal">
            <p class="total-title"><?= Yii::t('frontend', 'Total') ?>:</p>
            <span class="total-price"><span class="total-price-symbol"></span><?= Yii::$app->formatter->asCurrency($total) ?></span>
        </div>
        <div class="actions">
            <?= Html::a('<span>' . Yii::t('frontend', 'View Cart') . '</span>', ['/shop/cart'], ['class' => 'button-viewcart', 'data-pjax' => 0]) ?>
            <?= Html::a('<span>' . Yii::t('frontend', 'Checkout') . '</span>', ['/shop/checkout'], ['class' => 'button-checkout', 'data-pjax' => 0]) ?>
        </div>
    </div>
<?php } else { ?>
    <div class="minicart-content">
        <h4><?= Yii::t('frontend', 'No products in the cart.') ?></h4>
        <?= Html::a(Yii::t('frontend', 'Start shopping') . '<i class="fas fa-arrow-right"></i>', ['/shop/index'], ['class' => 'to-cart', 'data-pjax' => 0]) ?>
        <?= Html::a(Yii::t('frontend', 'Our Shipping & Return Policy'), ['/page/view', 'alias' => 'delivery'], ['class' => 'des-cart', 'data-pjax' => 0]) ?>
    </div>
<?php } ?>