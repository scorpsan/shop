<?php
/**
 * @var array $params
 */
?>

<?= Yii::t('frontend', 'We received your order number {orderN}', ['orderN' => $params['order']->order_number]) ?>

<?= Yii::t('frontend', 'You can track the status of the order, see the details, notify of the receipt by clicking on the link') ?>

<?= \yii\helpers\Url::to(['/user/orders/view', 'number' => $params['order']->order_number, 'token' => $params['order']->token], true) ?>

<?= Yii::t('frontend', 'Or in the My Account on the page "My Orders"') ?>

<?= Yii::t('frontend', 'We will contact you as soon as possible to confirm the order and clarify the terms of delivery') ?>