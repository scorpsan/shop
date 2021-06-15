<?php
/**
 * @var \common\models\ShopOrders $order
 */
?>
<?= Yii::t('frontend', 'We received your order number {orderN}', ['orderN' => $order->order_number]) ?>

<?= Yii::t('frontend', 'You can track the status of the order, see the details, notify of the receipt by clicking on the link') ?>

<?= Yii::$app->urlManager->createAbsoluteUrl(['/user/orders/view', 'number' => $order->order_number, 'token' => $order->token]) ?>

<?= Yii::t('frontend', 'Or in the My Account on the page "My Orders"') ?>

<?= Yii::t('frontend', 'We will contact you as soon as possible to confirm the order and clarify the terms of delivery') ?>