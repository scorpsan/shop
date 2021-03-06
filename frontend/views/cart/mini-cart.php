<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $cartQty int
 */

use yii\bootstrap4\Html;

$total = 0;
$canCheckout = true;
?>
<?php if ($cartQty) { ?>
    <div class="minicart-scroll-content">
    <?php foreach ($cartList as $key => $prod) {
        if ($productList[$key]->in_stock) {
            $price = (($productList[$key]->sale) ? $productList[$key]->sale : $productList[$key]->price);
            $totalPrice = $prod['qty'] * $price;
            $total += $totalPrice;
        } else {
            $canCheckout = false;
        }
        ?>
        <ul class="minicart-item list-unstyled">
            <li class="product-cart">
                <?= Html::a(Html::img($productList[$key]->smallImageMain, ['alt' => $productList[$key]->title, 'class' => 'img-fluid']), ['/shop/product', 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title, 'class' => 'product-image product-thumb-link', 'data-pjax' => 0]) ?>
                <div class="product-detail">
                    <h3 class="product-name">
                        <?= Html::a($productList[$key]->title, ['/shop/product', 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title, 'data-pjax' => 0]) ?>
                    </h3>
                    <div class="product-detail-info">
                        <span class="product-quantity"><?= Yii::t('frontend', 'QTY') ?>: <?= $prod['qty'] ?></span>
                        <span class="product-price"><?php if ($productList[$key]->in_stock) { ?><span class="product-price-symbol"></span><?= Yii::$app->formatter->asCurrency($price) ?><?php } else { ?><?= Yii::t('frontend', 'Out of Stock') ?><?php } ?></span>
                        <div class="product-remove float-right">
                            <?= Html::a('<i class="fas fa-trash" aria-hidden="true"></i>', ['/cart/delete'], ['title' => Yii::t('frontend', 'Delete'), 'class' => 'delete-from-cart', 'data-id' => $key]) ?>
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
            <?= Html::a('<span>' . Yii::t('frontend', 'Checkout') . '</span>', ['/checkout/index'], ['class' => 'button-checkout', 'disabled' => ($canCheckout)?false:'disabled', 'data-pjax' => 0]) ?>
        </div>
    </div>
<?php } else { ?>
    <div class="minicart-content">
        <h4><?= Yii::t('frontend', 'No products in the cart.') ?></h4>
        <?= Html::a(Yii::t('frontend', 'Start shopping') . '<i class="fas fa-arrow-right"></i>', ['/shop/index'], ['class' => 'to-cart', 'data-pjax' => 0]) ?>
        <?= Html::a(Yii::t('frontend', 'Our Shipping & Return Policy'), ['/page/view', 'alias' => 'delivery'], ['class' => 'des-cart', 'data-pjax' => 0]) ?>
    </div>
<?php } ?>