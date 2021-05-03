<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;
use Yii;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\httpclient\Response;

class bePaidOnline implements PaymentMethod
{
    /**
     * URL API платежного шлюза
     */
    const PROD_URL = 'https://checkout.bepaid.by';

    public static function name(): string
    {
        return 'bePaid Online';
    }

    public static function pay($order_number, $amount, $currency = null, $urls = null): bool
    {
        $data = [
            'checkout' => [
                'order' => [
                    'amount' => $amount * 100,
                    'currency' => ($currency) ? $currency : Yii::$app->formatter->currencyCode,
                    'description' => Yii::t('frontend', 'Order N' . ': ' . $order_number),
                    'tracking_id' => $order_number,
                ],
                'settings' => [
                    'return_url' => (isset($urls['return_url'])) ? $urls['return_url'] : Url::home(true),
                    'cancel_url' => (isset($urls['cancel_url'])) ? $urls['cancel_url'] : Url::home(true),
                    'notification_url' => (isset($urls['notification_url'])) ? $urls['notification_url'] : '',
                    'auto_return' => 0,
                ],
                'transaction_type' => 'payment',
                'version' => 2,
            ]
        ];

        $response = static::gateway('/ctp/api/checkouts', $data);

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', 'Failed: Pay Gateway Error - ' . ($response->getData())['Error']);
            Yii::debug('Failed: Pay Gateway Error - ' . ($response->getData())['Error']);
        } else {
            header('Location: ' . json_decode($response->getBody())->redirect_url);
            die();
        }

        return false;
    }

    public static function success(): bool
    {
        return false;
    }

    public static function notify(): bool
    {
        return false;
    }

    private static function gateway($method, $data): Response
    {
        if (Yii::$app->params['bePaidOnline']['test']) {
            $data['checkout']['test'] = true;
        }

        $shopID = Yii::$app->params['bePaidOnline']['login'];
        $secretKey = Yii::$app->params['bePaidOnline']['password'];

        $client = new Client([
            'baseUrl' => self::PROD_URL,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

        $response = $client->post($method, $data, [
            'Accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization', 'Basic ' . base64_encode("$shopID:$secretKey")
        ])->send();

        return $response;
    }

}