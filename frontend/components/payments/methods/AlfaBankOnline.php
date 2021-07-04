<?php
namespace frontend\components\payments\methods;

use frontend\components\payments\PaymentMethod;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\httpclient\Client;

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

    public static function pay($order_number, $amount, $currency = null, $urls = null): array
    {
        $data = [
            'userName' => Yii::$app->params['payments']['AlfaBankOnline']['login'],
            'password' => Yii::$app->params['payments']['AlfaBankOnline']['password'],
            'orderNumber' => $order_number, //Уникальный номер заказа
            'amount' => $amount * 100, // Сумма оплаты, передаётся цена*100, например, 22.32 BYN, то в этот параметр передаём 2232
            'returnUrl' => ArrayHelper::getValue($urls, 'return_url', Url::home(true)),
        ];

        $response = static::gateway('register.do', $data);

        if ($response->isOk) {
            return [
                'success' => true,
                'redirect_url' => $response['formUrl'],
                'payment_token' => $response['order_id'],
            ];
        }

        return [
            'error' => true,
            'message' => $response['Error'],
        ];
    }

    public static function payNow($token): array
    {
        return [
            'redirect_url' => self::PROD_URL . '?order_id=' . $token,
        ];
    }

    public static function success($request): array
    {
        return ['status' => self::PAYMENTS_PAID, 'type' => 'success', 'message' => Yii::t('frontend', 'Thank you for paying your order')];
    }

    public static function notify($request): int
    {
        return self::PAYMENTS_PAID;
    }

    private static function gateway($method, $data)
    {
        $GATEWAY_URL = self::PROD_URL;
        if (Yii::$app->params['payments']['AlfaBankOnline']['test']) {
            $GATEWAY_URL = self::TEST_URL;
        }

        $client = new Client(['baseUrl' => $GATEWAY_URL]);

        $response = $client->post($method, $data)->send();

        return $response->getData();
    }

}