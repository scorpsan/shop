<?php
namespace frontend\components\payments\methods;

use frontend\components\payments\PaymentMethod;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\httpclient\Client;

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

    public static function pay($order_number, $amount, $currency = null, $urls = null): array
    {
        $amount = $amount * 100;

        $data = [
            'checkout' => [
                'order' => [
                    'amount' => (int) ($amount),
                    'currency' => ($currency) ? $currency : Yii::$app->formatter->currencyCode,
                    'description' => Yii::t('frontend', 'Order N' . ': ' . $order_number),
                    'tracking_id' => $order_number,
                ],
                'settings' => [
                    'return_url' => ArrayHelper::getValue($urls, 'return_url', Url::home(true)),
                    'cancel_url' => ArrayHelper::getValue($urls, 'cancel_url', Url::home(true)),
                    'notification_url' => ArrayHelper::getValue($urls, 'notification_url', Url::home(true)),
                    'language' => Yii::$app->language,
                ],
                'transaction_type' => 'payment',
            ]
        ];

        $response = static::gateway('/ctp/api/checkouts', $data);

        $answer = json_decode($response->getContent());

        Yii::warning('debug',  VarDumper::dumpAsString($answer));

        if ($response->isOk) {
            return [
                'success' => true,
                'redirect_url' => $answer->checkout->redirect_url,
                'payment_token' => $answer->checkout->token,
            ];
        }

        return [
            'error' => true,
            'message' => $answer->message,
        ];
    }

    public static function payNow($token): array
    {
        return [
            'redirect_url' => self::PROD_URL . '/v2/checkout?token=' . $token,
        ];
    }

    public static function success($request): array
    {
        if (!isset($request['status'])) {
            return ['status' => false];
        }

        if ($status = static::status($request['status'])) {
            if ($status == self::PAYMENTS_PAID)
                return ['status' => $status, 'type' => 'success', 'message' => Yii::t('frontend', 'Thank you for paying your order')];
            if ($status == self::PAYMENTS_WAIT)
                return ['status' => $status, 'type' => 'warning', 'message' => Yii::t('frontend', 'Payment was declined or incomplete')];
        }

        return ['status' => false];
    }

    /*
    stdClass Object (
        [transaction] => stdClass Object (
            [uid] => 86034052-43423bc1b8
            [status] => successful
            [amount] => 4150
            [currency] => BYN
            [description] => Order N: BK1621431434
            [type] => payment
            [payment_method_type] => credit_card
            [tracking_id] => BK1621431434
            [message] => Successfully processed
            [test] => 1
            [created_at] => 2021-05-19T20:31:19.313Z
            [updated_at] => 2021-05-19T20:31:25.428Z
            [paid_at] => 2021-05-19T20:31:25.405Z
            [expired_at] =>
            [closed_at] =>
            [settled_at] =>
            [manually_corrected_at] =>
            [language] => ru
            [redirect_url] => https://gateway.bepaid.by/process/86034052-43423bc1b8
            [credit_card] => stdClass Object (
                [holder] => WERWT ERTER
                [stamp] => b3839d334ba40e89168d60cd9f9d1390aee3fe67dd4d5c41adbf3998043eaef8
                [brand] => visa
                [last_4] => 0000
                [first_1] => 4
                [bin] => 420000
                [issuer_country] => US
                [issuer_name] => VISA Demo Bank
                [product] => F
                [exp_month] => 12
                [exp_year] => 2023
                [token_provider] =>
                [token] =>
            )
            [receipt_url] => https://merchant.bepaid.by/customer/transactions/86034052-43423bc1b8/28bcf7668b4e28f2a13ffbb037460188bdc7930dbd12ee9e5d067807079ac2d2
            [id] => 86034052-43423bc1b8
            [additional_data] => stdClass Object (
                [request_id] => 29b718eb-2e40-449c-b42b-3e0c2353bb85
                [browser] => stdClass Object (
                    [screen_width] => 1680
                    [screen_height] => 1050
                    [screen_color_depth] => 24
                    [language] => ru
                    [java_enabled] =>
                    [user_agent] => Mozilla/5.0 (Macintosh; Intel Mac OS X 11_3_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.128 Safari/537.36 OPR/75.0.3969.218
                    [time_zone] => -180
                    [accept_header] => application/json
                )
                [vendor] => stdClass Object (
                    [name] => CTP
                    [token] => 77a424684fd077494173f1e07ae53d9d39543e3c5fe34c48bf67a3d82b15be26
                )
            )
            [be_protected_verification] => stdClass Object (
                [status] => successful
                [message] =>
                [white_black_list] => stdClass Object (
                    [email] => absent
                    [ip] => absent
                    [card_number] => white
                )
            )
            [payment] => stdClass Object (
                [auth_code] => 654321
                [bank_code] => 05
                [rrn] => 999
                [ref_id] => 777888
                [message] => Payment was approved
                [amount] => 4150
                [currency] => BYN
                [billing_descriptor] => test descriptor
                [gateway_id] => 36251
                [status] => successful
            )
            [avs_cvc_verification] => stdClass Object (
                [avs_verification] => stdClass Object (
                    [result_code] => 1
                )
                [cvc_verification] => stdClass Object (
                    [result_code] => 1
                )
            )
            [customer] => stdClass Object (
                [ip] => 37.214.53.178
                [email] =>
                [device_id] =>
                [birth_date] =>
            )
            [billing_address] => stdClass Object (
                [first_name] =>
                [last_name] =>
                [address] =>
                [country] =>
                [city] =>
                [zip] =>
                [state] =>
                [phone] =>
            )
        )
    )
    */
    public static function notify($request): int
    {
        if (!isset($request->transaction)) {
            return false;
        }

        return static::status($request->transaction->status);
    }

    private static function status($status): int
    {
        switch ($status) {
            case 'successful':
                return self::PAYMENTS_PAID;
            case 'failed':
            case 'incomplete':
            case 'expired':
                return self::PAYMENTS_WAIT;
            default:
                return 0;
        }
    }

    private static function gateway($method, $data)
    {
        if (Yii::$app->params['payments']['bePaidOnline']['test']) {
            $data['checkout']['test'] = true;
        }

        $shopID = Yii::$app->params['payments']['bePaidOnline']['shopId'];
        $secretKey = Yii::$app->params['payments']['bePaidOnline']['secretKey'];

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
            'Authorization' => 'Basic ' . base64_encode("$shopID:$secretKey"),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-API-Version' => 2,
        ])->send();

        return $response;
    }

}