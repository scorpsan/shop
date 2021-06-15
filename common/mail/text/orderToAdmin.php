<?php
/**
 * @var \common\models\ShopOrders $order
 */
?>
<?= Yii::t('frontend', 'New Order') ?>: <?= $order->order_number ?>

<?= Yii::t('frontend', 'Product') ?> / <?= Yii::t('frontend', 'QTY') ?> * <?= Yii::t('frontend', 'Price') ?> = <?= Yii::t('frontend', 'Subtotal') ?>

<?php $qty = 0; ?>
<?php foreach ($order->items as $item) { ?>
    <?= $item->product_name ?> (Code: <?= $item->product_code ?>) / <?= $item->quantity ?> * <?= Yii::$app->formatter->asCurrency($item->price, $order->currency) ?> = <?= Yii::$app->formatter->asCurrency($item->quantity * $item->price, $order->currency) ?>
    <?php $qty += $item->quantity; ?>
<?php } ?>

<?= Yii::t('frontend', 'Shipping') . ': ' . $order->delivery_method_name ?> / <?= (($order->delivery_cost) ? Yii::$app->formatter->asCurrency($order->delivery_cost, $order->currency) : Yii::t('frontend','free')) ?>

<?= Yii::t('frontend', 'Payment') . ': ' . $order->payment_method_name ?>

<?= Yii::t('frontend', 'Total') ?>: <?= Yii::$app->formatter->asCurrency($order->amount, $order->currency) ?>

<?= Yii::t('frontend', 'Shipping address') . ':' ?>
<?= $order->customer_name ?>
<?= $order->delivery_postal ?>, <?= $order->delivery_address ?>
<?= $order->customer_phone ?>

<?php if ($order->note) { ?>
    <?= Yii::t('frontend', 'Comment') . ':' ?> <?= $order->note ?>
<?php } ?>