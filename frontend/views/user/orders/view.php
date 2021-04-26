<?php
/**
 * @var View          $this
 * @var \frontend\models\ShopOrders $order
 */

use shop\StatusStyle;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

$this->title = $order->order_number;
?>
<section class="section-account p-0 m-0">
    <div class="my-container">
        <?php if (!Yii::$app->user->isGuest) { ?>
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
                $breadcrumbs[] = ['label' => Yii::t('frontend', 'My Orders'), 'url' => ['/user/orders/index']];
                $breadcrumbs[] = $this->title;
                ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                    'tag' => 'div',
                    'options' => ['class' => 'product-toolbar'],
                    'itemTemplate' => '{link} / ',
                    'activeItemTemplate' => '<span>{link}</span>',
                ]); ?>
        <?php } else { ?>
        <div>
            <div class="padding-top-60">
        <?php } ?>
                <?= $this->render('../shared/_alert') ?>

                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="font-weight-bold"><?= Html::encode(Yii::t('frontend', 'Order') . ' ' . $this->title) ?></h3>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <?php Pjax::begin(['id'=> 'order-pjax','enablePushState' => false]); ?>
                            <div class="table-responsive mb-30">
                                <table class="table table-hover black-text">
                                    <thead>
                                        <tr>
                                            <th class="font-300 fz-18"><?= Yii::t('frontend', 'Order N') ?></th>
                                            <th class="font-300 fz-18"><?= Yii::t('frontend', 'Date') ?></th>
                                            <th class="text-center font-300 fz-18"><?= Yii::t('frontend', 'Total') ?></th>
                                            <th class="text-center font-300 fz-18"><?= Yii::t('frontend', 'Status') ?></th>
                                            <th class="text-center font-300 fz-18"><span class="d-mobile-none"><?= Yii::t('frontend', 'Action') ?></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $item = $order ?>
                                            <tr>
                                                <td><?= Html::a($item->order_number, ['/user/orders/view', 'number' => $item->order_number]) ?></td>
                                                <td><?= Yii::$app->formatter->asDate($item->created_at) ?></td>
                                                <td class="text-center dollar"><?= Yii::$app->formatter->asCurrency($item->amount, $item->currency) ?></td>
                                                <td class="text-center"><?= ($item->paymentStatus->status == $item->deliveryStatus->status) ? StatusStyle::HtmlStatus($item->paymentStatus->status) : StatusStyle::HtmlStatus($item->paymentStatus->status) . ' / ' . StatusStyle::HtmlStatus($item->deliveryStatus->status) ?></td>
                                                <td class="text-center wish-actions">
                                                    <?= Html::a('<i class="fas fa-dolly" aria-hidden="true"></i>', ['/user/orders/received', 'number' => $item->order_number], ['title' => Yii::t('frontend', 'Order received'), 'class' => 'order-received', 'data-pjax' => 0]) ?>
                                                    <?= Html::a('<i class="fas fa-times" aria-hidden="true"></i>', ['/user/orders/cancel', 'number' => $item->order_number], ['title' => Yii::t('frontend', 'Cancel order'), 'class' => 'order-cancel', 'data-pjax' => 0]) ?>
                                                </td>
                                            </tr>
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