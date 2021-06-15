<?php
namespace shop;

use Yii;

class MailFactory
{

    public static function sendOrderToUser($order): bool
    {
        if (isset($order->customer_email)) {
            $emailSend = Yii::$app->mailer;
            $emailSend->setViewPath('@common/mail');

            $view = 'orderToUser';
            return $emailSend->compose(['html' => $view, 'text' => "text/{$view}"], ['order' => $order])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo($order->customer_email)
                ->setSubject(Yii::t('frontend', 'New Order'))
                ->send();
        }

        return false;
    }

    public static function sendOrderToAdmin($order): bool
    {
        $emailSend = Yii::$app->mailer;
        $emailSend->setViewPath('@common/mail');

        $view = 'orderToAdmin';
        return $emailSend->compose(['html' => $view, 'text' => "text/{$view}"], ['order' => $order])
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject(Yii::t('frontend', 'New Order'))
            ->send();
    }

}