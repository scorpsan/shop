<?php
/**
 * @var \common\models\ShopOrders $order
 */

use yii\helpers\Html;
?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'We received your order number {orderN}', ['orderN' => $order->order_number]) ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'You can track the status of the order, see the details, notify of the receipt by clicking on the link') ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Html::a(Yii::$app->urlManager->createAbsoluteUrl(['/user/orders/view', 'number' => $order->order_number, 'token' => $order->token]), Yii::$app->urlManager->createAbsoluteUrl(['/user/orders/view', 'number' => $order->order_number, 'token' => $order->token])) ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'Or in the My Account on the page "My Orders"') ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'We will contact you as soon as possible to confirm the order and clarify the terms of delivery') ?>
</p>