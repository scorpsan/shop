<?php
namespace frontend\components;

use frontend\components\jobs\MailSendJob;
use Yii;

class MailFactory
{

    public static function sendOrderToUser($order): bool
    {
        if (isset($order->customer_email) && $order->customer_email != '') {
            Yii::$app->queueMail->delay(2 * 60)->push(new MailSendJob([
                'view' => 'orderToUser',
                'lng' => Yii::$app->language,
                'fromEmail' => [Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']],
                'toEmail' => $order->customer_email,
                'subject' => Yii::t('frontend', 'New Order'),
                'params' => [
                    'order' => $order,
                    'siteSettings' => Yii::$app->params['siteSettings'],
                ],
            ]));

            return true;
        }

        return false;
    }

    public static function sendOrderToAdmin($order): bool
    {
        Yii::$app->queueMail->delay(2 * 60)->push(new MailSendJob([
            'view' => 'orderToAdmin',
            'lng' => Yii::$app->language,
            'fromEmail' => [Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']],
            'toEmail' => Yii::$app->params['adminEmail'],
            'subject' => Yii::t('frontend', 'New Order'),
            'params' => [
                'order' => $order,
                'siteSettings' => Yii::$app->params['siteSettings'],
            ],
        ]));

        return true;
    }

}