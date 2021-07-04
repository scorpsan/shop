<?php
namespace frontend\components\payments;

interface PaymentMethod
{
    const PAYMENTS_WAIT = 1;
    const PAYMENTS_PAID = 2;
    const PAYMENTS_CANCEL = 3;
    const PAYMENTS_REFUND = 4;

    /**
     * @return string
     */
    public static function name(): string;

    /**
     * @param $order_number
     * @param $amount
     * @param $currency
     * @param $urls array|null
     * @return array
     */
    public static function pay($order_number, $amount, $currency = null, $urls = null): array;

    /**
     * @param $token
     * @return array
     */
    public static function payNow($token): array;

    /**
     * @param $request
     * @return array
     */
    public static function success($request): array;

    /**
     * @param $request
     * @return int
     */
    public static function notify($request): int;

}