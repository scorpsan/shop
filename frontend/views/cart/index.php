<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $cartQty int
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Shopping Cart');

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Your Shopping Cart');

$nullPrice = false;
$total = 0;
?>
<section class="section-cart">
    <?= $this->render('../layouts/_alert') ?>

    <div class="my-container">
        <div class="content-cart-page">
            <?php Pjax::begin(['id'=> 'cart-pjax','enablePushState' => false]); ?>
                <div class="table-responsive">
                    <table class="shop_table table--responsive cart table">
                        <thead>
                        <tr class="cart-title">
                            <th colspan="2" class="product-thumbnail"><?= Yii::t('frontend', 'Product') ?></th>
                            <th class="product-price"><?= Yii::t('frontend', 'Price') ?></th>
                            <th class="product-quantity"><?= Yii::t('frontend', 'QTY') ?></th>
                            <th class="product-subtotal"><?= Yii::t('frontend', 'Total') ?></th>
                            <th class="product-remove">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($cartQty) {
                            foreach ($cartList as $key => $prod) {
                                $price = (($productList[$key]->sale) ? $productList[$key]->sale : $productList[$key]->price);
                                $totalPrice = $prod['qty'] * $price;
                                $total += $totalPrice;
                                ?>
                                <tr class="cart_item">
                                    <td data-label="Product Image" class="product-thumbnail">
                                        <?= Html::a(Html::img($productList[$key]->smallImageMain, ['alt' => $productList[$key]->title, 'class' => 'img-fluid', 'width' => '100', 'height' => '100']), ['/shop/product', 'categoryalias' => ($productList[$key]->category->depth > 0) ? $productList[$key]->category->alias : null, 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title]) ?>
                                    </td>
                                    <td data-title="Product Name" class="product-name-thumb" data-title="<?= Yii::t('frontend', 'Product') ?>">
                                        <?= Html::a($productList[$key]->title, ['/shop/product', 'categoryalias' => ($productList[$key]->category->depth > 0) ? $productList[$key]->category->alias : null, 'alias' => $productList[$key]->alias], ['title' => $productList[$key]->title]) ?>
                                    </td>
                                    <td data-label="Product Price" class="product-price" data-title="<?= Yii::t('frontend', 'Price') ?>">
                                        <span class="amount"><?= Yii::$app->formatter->asCurrency($price) ?></span>
                                    </td>
                                    <td data-label="Quantity" class="product-quantity" data-title="<?= Yii::t('frontend', 'QTY') ?>">
                                        <div class="js-qty">
                                            <?= Html::a('<span class="icon icon-minus" aria-hidden="true"></span><i class="fas fa-chevron-down" aria-hidden="true"></i>', ['/cart/minus'], [
                                                'class' => 'js-qty__adjust js-qty__adjust--minus icon-fallback-text item-minus-cart', 'data-id' => $key
                                            ]) ?>
                                            <input type="text" class="js-qty__num" value="<?= $prod['qty'] ?>" min="1" data-id="<?= $key ?>" aria-label="quantity" pattern="[0-9]*" name="updates[]">
                                            <?= Html::a('<span class="icon icon-plus" aria-hidden="true"></span><i class="fas fa-chevron-up" aria-hidden="true"></i>', ['/cart/plus'], [
                                                'class' => 'js-qty__adjust js-qty__adjust--plus icon-fallback-text item-plus-cart', 'data-id' => $key
                                            ]) ?>
                                        </div>
                                    </td>
                                    <td data-label="Sub Total" class="product-subtotal" data-title="<?= Yii::t('frontend', 'Total') ?>">
                                        <span class="amount"><?= Yii::$app->formatter->asCurrency($totalPrice) ?></span>
                                    </td>
                                    <td class="text-center cart-actions">
                                        <?= Html::a('<i class="fas fa-heart" aria-hidden="true"></i>', ['/cart/to-wish'], ['class' => 'from-cart-to-wish', 'data-id' => $key]) ?>
                                        <?= Html::a('<i class="fas fa-trash" aria-hidden="true"></i>', ['/cart/delete'], ['class' => 'delete-from-cart remove', 'data-id' => $key]) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="cart_item"><td colspan="6" class="product-name-thumb"><h3><?= Yii::t('frontend', 'No products in the cart.') ?></h3></td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart_totals">
                    <?php if (empty($cartList)) { ?>
                        <div class="cart-button">
                            <?= Html::a(Yii::t('frontend', 'Start shopping'), ['/shop/index'], ['class' => 'shop-button']) ?>
                        </div>
                    <?php } else { ?>
                        <div class="cart-button">
                            <?= Html::a(Yii::t('frontend', 'Update Cart'), ['/cart/update'], ['class' => 'shop-button update-cart']) ?>
                        </div>
                        <div class="cart-button">
                            <?= Html::a(Yii::t('frontend', 'Clear Cart'), ['/cart/clear'], ['class' => 'shop-button clear-cart']) ?>
                        </div>
                        <div class="cart-button">
                            <?= Html::a(Yii::t('frontend', 'Continue Shopping'), ['/shop/index'], ['class' => 'shop-button']) ?>
                        </div>

                        <div class="cart-check">
                            <h2 class="cart-title"><?= Yii::t('frontend', 'Cart Totals') ?></h2>
                            <table class="total-checkout" width="100%">
                                <tbody>
                                <tr>
                                    <th class="cart-label"><span><?= Yii::t('frontend', 'Total') ?></span></th>
                                    <td class="cart-amount"><span> <strong><span class="amount"><?= Yii::$app->formatter->asCurrency($total) ?></span></strong> </span></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="wc-proceed-to-checkout clearfix">
                                <?= Html::a(Yii::t('frontend', 'Check Out'), ['/cart/checkout'], ['class' => 'shop-button checkout-button button alt wc-forward bg-color']) ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</section>