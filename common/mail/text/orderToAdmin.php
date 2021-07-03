<?php
/**
 * @var array $params
 */
?>
<?= Yii::t('frontend', 'New Order') ?>: <?= $params['order']->order_number ?>

<?= Yii::t('frontend', 'Product') ?> / <?= Yii::t('frontend', 'QTY') ?> * <?= Yii::t('frontend', 'Price') ?> = <?= Yii::t('frontend', 'Subtotal') ?>

<?php $qty = 0; ?>
<?php foreach ($params['order']->items as $item) { ?>
    <?= $item->product_name ?> (Code: <?= $item->product_code ?>) / <?= $item->quantity ?> * <?= Yii::$app->formatter->asCurrency($item->price, $params['order']->currency) ?> = <?= Yii::$app->formatter->asCurrency($item->quantity * $item->price, $params['order']->currency) ?>
    <?php $qty += $item->quantity; ?>
<?php } ?>

<?= Yii::t('frontend', 'Shipping') . ': ' . $params['order']->delivery_method_name ?> / <?= (($params['order']->delivery_cost) ? Yii::$app->formatter->asCurrency($params['order']->delivery_cost, $params['order']->currency) : Yii::t('frontend','free')) ?>

<?= Yii::t('frontend', 'Payment') . ': ' . $params['order']->payment_method_name ?>

<?= Yii::t('frontend', 'Total') ?>: <?= Yii::$app->formatter->asCurrency($params['order']->amount, $params['order']->currency) ?>

<?= Yii::t('frontend', 'Shipping address') . ':' ?>
<?= $params['order']->customer_name ?>
<?= $params['order']->delivery_postal ?>, <?= $params['order']->delivery_address ?>
<?= $params['order']->customer_phone ?>

<?php if ($params['order']->note) { ?>
    <?= Yii::t('frontend', 'Comment') . ':' ?> <?= $params['order']->note ?>
<?php } ?>