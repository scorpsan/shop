<?php
/**
 * @var View          $this
 * @var \frontend\models\ShopOrders $orders
 */

use frontend\models\ShopOrdersStatuses;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'My Orders');
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
                        <?php Pjax::begin(['id'=> 'order-pjax','enablePushState' => false]); ?>
                            <?php if (count($orders)) { ?>
                                <!-- Bootstrap collapse-->
                                <div class="panel-custom-group text-left mb-4" id="accordion1" role="tablist" aria-multiselectable="true">
                                    <!-- Bootstrap panel-->
                                    <?php foreach ($orders as $order) { ?>
                                        <div class="panel panel-custom panel-custom-default w-100">
                                            <div class="panel-custom-heading" id="accordion1Heading<?= $order->id ?>" role="tab">
                                                <div class="panel-custom-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion1" href="#accordion1Collapse<?= $order->id ?>" aria-controls="accordion1Collapse<?= $order->id ?>">
                                                        &nbsp;
                                                        <span class="col-sm-3"><?= Yii::t('frontend', 'Order N') . ': ' . $order->order_number ?></span>
                                                        <span class="col-sm-3"><?= Yii::$app->formatter->asDate($order->created_at) ?></span>
                                                        <span class="col-sm-2"><?= Yii::$app->formatter->asCurrency($order->amount - $order->discount, $order->currency) ?></span>
                                                        <span class="col-sm-2">
                                                            <?= ($order->paymentStatus->status == $order->deliveryStatus->status) ? ShopOrdersStatuses::HtmlStatus($order->paymentStatus->status) : ShopOrdersStatuses::HtmlStatus($order->paymentStatus->status) . ' / ' . ShopOrdersStatuses::HtmlStatus($order->deliveryStatus->status) ?>
                                                        </span>
                                                        <span class="col-sm-1"></span>
                                                    </a>
                                                </div>
                                                <div class="orders-icon">
                                                    <?php if ($order->canPay) { ?>
                                                        <?= Html::a('<i class="fas fa-hand-holding-usd" aria-hidden="true"></i>', ['/user/orders/pay', 'number' => $order->order_number], ['title' => Yii::t('frontend', 'Pay for the Order'), 'class' => 'order-pay']) ?>
                                                    <?php } ?>
                                                    <?php if ($order->canDelivered) { ?>
                                                        <?= Html::a('<i class="fas fa-clipboard-check" aria-hidden="true"></i>', ['/user/orders/received', 'number' => $order->order_number], ['title' => Yii::t('frontend', 'Order Received'), 'class' => 'order-received']) ?>
                                                    <?php } ?>
                                                    <?php if ($order->canCancel) { ?>
                                                        <?= Html::a('<i class="far fa-trash-alt" aria-hidden="true"></i>', ['/user/orders/cancel', 'number' => $order->order_number], ['title' => Yii::t('frontend', 'Cancel Order'), 'class' => 'order-cancel']) ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="panel-custom-collapse collapse" id="accordion1Collapse<?= $order->id ?>" role="tabpanel" aria-labelledby="accordion1Heading<?= $order->id ?>">
                                                <div class="panel-custom-body">
                                                    <div class="table-responsive mb-4">
                                                        <table class="shop_table table--responsive cart table bg-white">
                                                            <thead>
                                                            <tr class="cart-title">
                                                                <th colspan="2" class="product-thumbnail"><?= Yii::t('frontend', 'Product') ?></th>
                                                                <th class="product-quantity text-center"><?= Yii::t('frontend', 'QTY') ?></th>
                                                                <th class="product-price text-center"><?= Yii::t('frontend', 'Price') ?></th>
                                                                <th class="product-subtotal text-center"><?= Yii::t('frontend', 'Subtotal') ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $qty = 0; ?>
                                                            <?php foreach ($order->items as $item) {
                                                                $url = Url::to(['/shop/product', 'alias' => $item->product->alias]);
                                                                ?>
                                                                <tr>
                                                                    <td><?= Html::a(Html::img($item->product->smallImageMain, ['alt' => $item->product_name, 'class' => 'img-fluid', 'width' => '100', 'height' => '100']), $url, ['title' => $item->product_name]) ?></a></td>
                                                                    <td><?= Html::a($item->product_name, $url, ['title' => $item->product_name]) ?><br>Code: <?= $item->product_code ?></td>
                                                                    <td class="text-center"><?= $item->quantity ?></td>
                                                                    <td class="text-center" nowrap><?= Yii::$app->formatter->asCurrency($item->price, $order->currency) ?></td>
                                                                    <td class="text-center" nowrap><?= Yii::$app->formatter->asCurrency($item->quantity * $item->price, $order->currency) ?></td>
                                                                </tr>
                                                                <?php $qty += $item->quantity; ?>
                                                            <?php } ?>
                                                            <tr>
                                                                <td colspan="4"><?= Yii::t('frontend', 'Shipping') . ': ' . $order->delivery_method_name ?></td>
                                                                <td class="text-center"><?= (($order->delivery_cost) ? Yii::$app->formatter->asCurrency($order->delivery_cost, $order->currency) : Yii::t('frontend','free')) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5"><?= Yii::t('frontend', 'Payment') . ': ' . $order->payment_method_name ?></td>
                                                            </tr>
                                                            <?php if ($order->discount) { ?>
                                                                <tr>
                                                                    <td colspan="4" style="color: red;"><?= Yii::t('frontend', 'Discount') ?></td>
                                                                    <td class="text-center" style="color: red;" nowrap>- <?= Yii::$app->formatter->asCurrency($order->discount, $order->currency) ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td colspan="2" style="font-weight: bold;font-size: 1.3em;"><?= Yii::t('frontend', 'Total') ?></td>
                                                                <td class="text-center" style="font-weight: bold;font-size: 1.1em;"><?= $qty ?></td>
                                                                <td nowrap></td>
                                                                <td class="text-center" style="font-weight: bold;font-size: 1.3em;" nowrap><?= Yii::$app->formatter->asCurrency($order->amount - $order->discount, $order->currency) ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row mb-4 mx-0">
                                                        <?php if (!$order->deliveryMethod->pickup) { ?>
                                                            <div class="col-sm-6 col-xs-12 mb-2 px-4">
                                                                <h5 class="cart-title"><?= Yii::t('frontend', 'Shipping address') . ':' ?></h5>
                                                                <p><?= $order->customer_name ?></p>
                                                                <p><?= $order->delivery_postal ?>, <?= $order->delivery_address ?></p>
                                                                <p><?= $order->customer_phone ?></p>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($order->note) { ?>
                                                            <div class="col-sm-6 col-xs-12 mb-2 px-4">
                                                                <h5 class="cart-title"><?= Yii::t('frontend', 'Comment') . ':' ?></h5>
                                                                <p><?= $order->note ?></p>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <p><?= Yii::t('frontend', 'You have not made a purchase yet.') ?></p>
                            <?php } ?>
                            <p><?= Yii::t('frontend', 'If you do not see your order, please contact us immediately, maybe it was issued to another E-mail or done without an entry.') ?></p>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>