<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;
use Yii;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\httpclient\Response;

class AlfaBankOnline implements PaymentMethod
{
    /**
     * URL API платежного шлюза
     */
    const PROD_URL = 'https://ecom.alfabank.by/payment/rest/';
    const TEST_URL = 'https://web.rbsuat.com/ab_by/rest/';

    public static function name(): string
    {
        return 'Alfa Bank Online';
    }

    public static function pay($order_number, $amount, $currency = null, $urls = null): bool
    {
        $data = [
            'userName' => Yii::$app->params['AlfaBankOnline']['login'],
            'password' => Yii::$app->params['AlfaBankOnline']['password'],
            'orderNumber' => $order_number, //Уникальный номер заказа
            'amount' => $amount * 100, // Сумма оплаты, передаётся цена*100, например, 22.32 BYN, то в этот параметр передаём 2232
            'returnUrl' => (isset($urls['return_url'])) ? $urls['return_url'] : Url::home(true),
        ];

        $response = static::gateway('register.do', $data);

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', 'Failed: Pay Gateway Error - ' . ($response->getData())['Error']);
            Yii::debug('Failed: Pay Gateway Error - ' . ($response->getData())['Error']);
        } else {
            header('Location: ' . $response->data['formUrl']);
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
        $GATEWAY_URL = self::PROD_URL;
        if (Yii::$app->params['AlfaBankOnline']['test']) {
            $GATEWAY_URL = self::TEST_URL;
        }

        $client = new Client(['baseUrl' => $GATEWAY_URL]);

        $response = $client->post($method, $data)->send();

        return $response;
    }

}