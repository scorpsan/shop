<?php
/**
 * @var $this           yii\web\View
 * @var $order          backend\models\ShopOrders
 */

use backend\components\widgets\DetailView;
use backend\models\ShopOrdersStatuses;
use yii\helpers\Html;

$this->title = Yii::t('backend', 'View Order') . ' <small>' . $order->order_number . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $order->order_number;
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $order->id], ['class' => 'btn btn-primary']) ?>
                    <?php if (Yii::$app->user->can('deletePages')) { ?>
                        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $order->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $order,
                    'attributes' => [
                        'order_number',
                        'created_at:datetime',
                        'updated_at:datetime',
                        'customer_name',
                        'customer_email:email',
                        'customer_phone',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <h5 class="cart-title"><?= Yii::t('backend', 'Shipping address') . ':' ?></h5>
                <?= DetailView::widget([
                    'model' => $order,
                    'attributes' => [
                        'delivery_postal',
                        'delivery_address',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <h5 class="cart-title"><?= Yii::t('backend', 'Comment') . ':' ?></h5>
                <p><?= $order->note ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= Yii::t('backend', 'Payment') . ': ' . $order->payment_method_name ?>
                <h5 class="cart-title"><?= Yii::t('backend', 'Status') . ': ' . ShopOrdersStatuses::HtmlStatus($order->paymentStatus->status) ?></h5>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= Yii::t('backend', 'Shipping') . ': ' . $order->delivery_method_name ?>
                <h5 class="cart-title"><?= Yii::t('backend', 'Status') . ': ' . ShopOrdersStatuses::HtmlStatus($order->deliveryStatus->status) ?></h5>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive mb-4">
                    <table class="shop_table table bg-white">
                        <thead>
                        <tr class="cart-title">
                            <th colspan="2" class="product-thumbnail"><?= Yii::t('backend', 'Product') ?></th>
                            <th class="product-quantity text-center"><?= Yii::t('backend', 'QTY') ?></th>
                            <th class="product-price text-center"><?= Yii::t('backend', 'Price') ?></th>
                            <th class="product-subtotal text-center"><?= Yii::t('backend', 'Subtotal') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $qty = 0; ?>
                        <?php foreach ($order->items as $item) {
                            $url = Yii::$app->urlManagerForFront->createAbsoluteUrl(['/shop/product', 'alias' => $item->product->alias]);
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
                            <td colspan="4"><?= Yii::t('backend', 'Shipping') ?></td>
                            <td class="text-center"><?= (($order->delivery_cost) ? Yii::$app->formatter->asCurrency($order->delivery_cost, $order->currency) : Yii::t('backend','free')) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= Yii::t('backend', 'Total') ?></td>
                            <td class="text-center"><?= $qty ?></td>
                            <td nowrap></td>
                            <td class="text-center" nowrap><?= Yii::$app->formatter->asCurrency($order->amount, $order->currency) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>