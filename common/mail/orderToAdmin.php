<?php
/**
 * @var \common\models\ShopOrders $order
 */

use yii\helpers\Html;
?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'New Order') ?>: <?= $order->order_number ?>
</p>

<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0; width: 100%;">
    <thead>
    <tr>
        <th colspan="2" style="font-weight: bold;"><?= Yii::t('frontend', 'Product') ?></th>
        <th style="font-weight: bold;"><?= Yii::t('frontend', 'QTY') ?></th>
        <th style="font-weight: bold;"><?= Yii::t('frontend', 'Price') ?></th>
        <th style="font-weight: bold;"><?= Yii::t('frontend', 'Subtotal') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $qty = 0; ?>
    <?php foreach ($order->items as $item) { ?>
        <tr>
            <td><?= Html::img(Yii::$app->urlManager->createAbsoluteUrl($item->product->smallImageMain), ['alt' => $item->product_name, 'class' => 'img-fluid', 'width' => '100', 'height' => '100']) ?></a></td>
            <td><?= $item->product_name ?><br>Code: <?= $item->product_code ?></td>
            <td><?= $item->quantity ?></td>
            <td nowrap><?= Yii::$app->formatter->asCurrency($item->price, $order->currency) ?></td>
            <td nowrap><?= Yii::$app->formatter->asCurrency($item->quantity * $item->price, $order->currency) ?></td>
        </tr>
        <?php $qty += $item->quantity; ?>
    <?php } ?>
    <tr>
        <td colspan="4" style="font-weight: bold;"><?= Yii::t('frontend', 'Shipping') . ': ' . $order->delivery_method_name ?></td>
        <td><?= (($order->delivery_cost) ? Yii::$app->formatter->asCurrency($order->delivery_cost, $order->currency) : Yii::t('frontend','free')) ?></td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold;"><?= Yii::t('frontend', 'Payment') . ': ' . $order->payment_method_name ?></td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;"><?= Yii::t('frontend', 'Total') ?></td>
        <td><?= $qty ?></td>
        <td></td>
        <td nowrap style="font-weight: bold;"><?= Yii::$app->formatter->asCurrency($order->amount, $order->currency) ?></td>
    </tr>
    </tbody>
</table>

<h5 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; font-weight: bold; margin: 0 0 10px; padding: 0;"><?= Yii::t('frontend', 'Shipping address') . ':' ?></h5>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><?= $order->customer_name ?></p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><?= $order->delivery_postal ?>, <?= $order->delivery_address ?></p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><?= $order->customer_phone ?></p>

<?php if ($order->note) { ?>
    <h5 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; font-weight: bold; margin: 0 0 10px; padding: 0;"><?= Yii::t('frontend', 'Comment') . ':' ?></h5>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><?= $order->note ?></p>
<?php } ?>