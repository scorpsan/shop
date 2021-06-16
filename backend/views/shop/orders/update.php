<?php
/**
 * @var $this           yii\web\View
 * @var $order          backend\models\ShopOrders
 */

use backend\components\widgets\DetailView;
use backend\models\ShopDelivery;
use backend\models\ShopOrdersStatuses;
use backend\models\ShopPayment;
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Order') . ' <small>' . $order->order_number . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $order->order_number;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?php $form = ActiveForm::begin(); ?>
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
                        'payment_status' => [
                            'attribute' => 'payment_status',
                            'label' => Yii::t('backend', 'Payment Status'),
                            'value' => function($order) {
                                return ShopOrdersStatuses::HtmlStatus($order->paymentStatus->status);
                            },
                            'format' => 'raw',
                        ],
                        'delivery_status' => [
                            'attribute' => 'delivery_status',
                            'label' => Yii::t('backend', 'Delivery Status'),
                            'value' => function($order) {
                                return ShopOrdersStatuses::HtmlStatus($order->deliveryStatus->status);
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($order, 'payment_method_id')->dropDownList(ShopPayment::listAll())->label(Yii::t('backend', 'Payment Method')); ?>

                <?= $form->field($order, 'delivery_method_id')->dropDownList(ShopDelivery::listAll())->label(Yii::t('backend', 'Delivery Method')); ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($order, 'tracker')->textInput(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <?= $form->field($order, 'customer_name')->textInput(); ?>

                <?= $form->field($order, 'customer_email')->textInput(); ?>

                <?= $form->field($order, 'customer_phone')->textInput(); ?>

                <h4 class="box-title"><?= Yii::t('backend', 'Shipping address') . ':' ?></h4>

                <?= $form->field($order, 'delivery_postal')->textInput(); ?>

                <?= $form->field($order, 'delivery_address')->textarea(['rows' => 5]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <h4 class="box-title"><?= Yii::t('backend', 'Comment') . ':' ?></h4>
                <p><?= $order->note ?></p>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($order, 'admin_note')->textarea(['rows' => 10]); ?>
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
                            <td colspan="4" style="color: red;"><?= Yii::t('backend', 'Discount') ?></td>
                            <td class="text-center"><?= $form->field($order, 'discount')->textInput()->label(false); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold;font-size: 1.5em;"><?= Yii::t('backend', 'Total') ?></td>
                            <td class="text-center" style="font-weight: bold;font-size: 1.3em;"><?= $qty ?></td>
                            <td nowrap></td>
                            <td class="text-center" style="font-weight: bold;font-size: 1.5em;" nowrap><?= Yii::$app->formatter->asCurrency($order->amount - $order->discount, $order->currency) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>
                    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>