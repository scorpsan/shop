<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;

class AlfaBankOnline implements PaymentMethod
{
    /**
     * URL API платежного шлюза
     */
    const RBS_PROD_URL = 'https://ecom.alfabank.by/payment/rest/';
    const RBS_TEST_URL = 'https://web.rbsuat.com/ab_by/rest/';

    public static function name(): string
    {
        return 'Alfa Bank Online';
    }

    public static function pay(): bool
    {
        /**
         * USERNAME , . Логин для интеграции сайта с платежным сервисом из письма после подтверждения заявки
         * PASSWORD , .Пароль для интеграции сайта с платежным сервисом из письма после подтверждения заявки
         * GATEWAY_URL .
         * RETURN_URL , Ссылка на страницу, куда будет отправлен человек
         */
        define('USERNAME', 'www.my-site.net-api');
        define('PASSWORD', 'trCIZNvd');
        define('GATEWAY_URL', 'https://web.rbsuat.com/ab_by/rest/');
        define('RETURN_URL', 'https://my-site');
        $phone = noprob($_POST['user-tel']);

        $data = array(
            'userName' => USERNAME,
            'password' => PASSWORD,
            'orderNumber' => $now, //Уникальный номер оплаты, например текущая дата до секунд+номер телефона
            'amount' => urlencode($_POST['cost_user']), // Сумма оплаты, передаётся цена*100, например, 22.32 BYN, то в этот параметр передаём 2232
            'returnUrl' => RETURN_URL
        );
        $response = static::gateway('registerPreAuth.do', $data);
        //print_r($response);
        if (isset($response['errorCode'])) { //
            echo ' #' . $response['errorCode'] . ': ' . $response['errorMessage'];
        } else { //
            header('Location: ' . $response['formUrl']);
            die();
        }
        return true;
    }

    private static function gateway($method, $data) {
        $curl = curl_init(); //
        curl_setopt_array($curl, array(
            CURLOPT_URL => GATEWAY_URL.$method, //
            CURLOPT_RETURNTRANSFER => true, //
            CURLOPT_POST => true, // POST
            CURLOPT_POSTFIELDS => http_build_query($data) //
        ));
        $response = curl_exec($curl); //

        $response = json_decode($response, true); // JSON
        curl_close($curl); //
        return $response; //
    }

}