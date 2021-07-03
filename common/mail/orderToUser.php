<?php
/**
 * @var array $params
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'We received your order number {orderN}', ['orderN' => $params['order']->order_number]) ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'You can track the status of the order, see the details, notify of the receipt by clicking on the link') ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Html::a(Html::encode(Url::to(['/user/orders/view', 'number' => $params['order']->order_number, 'token' => $params['order']->token], true)), Url::to(['/user/orders/view', 'number' => $params['order']->order_number, 'token' => $params['order']->token], true)) ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'Or in the My Account on the page "My Orders"') ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('frontend', 'We will contact you as soon as possible to confirm the order and clarify the terms of delivery') ?>
</p>