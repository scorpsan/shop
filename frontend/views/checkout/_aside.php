<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $shipMethod \frontend\models\ShopDelivery
 * @var $subtotal float
 * @var $total float
 */

use yii\bootstrap4\Html;
?>
<aside class="sidebar" role="complementary">
    <div class="sidebar__header">
        <?= Html::a('<span class="logo__text heading-1">' . Yii::$app->name . '</span>', ['/page/index'], ['title' => Yii::$app->name, 'class' => 'logo logo--left']) ?>
    </div>

    <div class="sidebar__content">
        <div id="order-summary" class="order-summary order-summary--is-collapsed">
            <div class="order-summary__sections">
                <div class="order-summary__section order-summary__section--product-list">
                    <div class="order-summary__section__content">
                        <table class="product-table">
                            <tbody>
                            <?php
                            foreach ($cartList as $key => $prod) {
                                $price = (($productList[$key]->sale) ? $productList[$key]->sale : $productList[$key]->price);
                                $totalPrice = $prod['qty'] * $price;
                                ?>
                                <tr class="product">
                                    <td class="product__image">
                                        <div class="product-thumbnail">
                                            <div class="product-thumbnail__wrapper">
                                                <?= Html::img($productList[$key]->smallImageMain, ['alt' => $productList[$key]->title, 'class' => 'product-thumbnail__image']) ?>
                                            </div>
                                            <span class="product-thumbnail__quantity" aria-hidden="true"><?= $prod['qty'] ?></span>
                                        </div>
                                    </td>
                                    <th class="product__description" scope="row">
                                        <span class="product__description__name order-summary__emphasis"><?= $productList[$key]->title ?></span>
                                        <span class="product__description__variant order-summary__small-text"><?php //Black / XS?></span>
                                    </th>
                                    <td class="product__quantity">
                                        <span class="visually-hidden"><?= $prod['qty'] ?></span>
                                    </td>
                                    <td class="product__price">
                                        <span class="order-summary__emphasis skeleton-while-loading"><?= Yii::$app->formatter->asCurrency($totalPrice) ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="order-summary__section order-summary__section--total-lines">
                    <table class="total-line-table">
                        <tbody class="total-line-table__tbody">
                        <tr class="total-line total-line--subtotal">
                            <th class="total-line__name" scope="row"><?= Yii::t('frontend', 'Subtotal') ?></th>
                            <td class="total-line__price">
                                <span class="order-summary__emphasis skeleton-while-loading"><?= Yii::$app->formatter->asCurrency($subtotal) ?></span>
                            </td>
                        </tr>
                        <?php if (isset($shipMethod)) { ?>
                        <tr class="total-line total-line--shipping">
                            <th class="total-line__name" scope="row"><span><?= Yii::t('frontend', 'Shipping') ?></span></th>
                            <td class="total-line__price">
                                <span class="skeleton-while-loading order-summary__emphasis"><?= Yii::$app->formatter->asCurrency($shipMethod->cost) ?></span>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot class="total-line-table__footer">
                        <tr class="total-line">
                            <th class="total-line__name payment-due-label" scope="row">
                                <span class="payment-due-label__total"><?= Yii::t('frontend', 'Total') ?></span>
                            </th>
                            <td class="total-line__price payment-due">
                                <span class="payment-due__currency remove-while-loading"><?= Yii::$app->formatter->currencyCode ?></span>
                                <span class="payment-due__price skeleton-while-loading--lg"><?= Yii::$app->formatter->asCurrency($total) ?></span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</aside>