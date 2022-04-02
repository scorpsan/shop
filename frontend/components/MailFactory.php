<?php
namespace frontend\components;

use frontend\components\jobs\MailSendJob;
use Yii;

class MailFactory
{

    public static function sendOrderToUser($order): bool
    {
        if (isset($order->customer_email) && $order->customer_email != '') {
            $emailSend = Yii::$app->mailer;
            $emailSend->setViewPath('@common/mail');
            $emailSend->compose(['html' => 'orderToUser', 'text' => "text/orderToUser"], ['content' => null, 'params' => [
                'order' => $order,
            ]])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo($order->customer_email)
                ->setSubject(Yii::t('frontend', 'New Order'))->send();

            Yii::$app->queueMail->delay(2 * 60)->push(new MailSendJob([
                'view' => 'orderToUser',
                'lng' => Yii::$app->language,
                'fromEmail' => [Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']],
                'toEmail' => $order->customer_email,
                'subject' => Yii::t('frontend', 'New Order'),
                'params' => [
                    'order' => $order,
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
            ],
        ]));

        return true;
    }

}