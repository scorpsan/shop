<?php
namespace shop\payments;

interface PaymentMethod
{
    /**
     * @return string
     */
    public static function name(): string;

    /**
     * @param $order_number
     * @param $amount
     * @param $currency
     * @param $urls array|null
     * @return bool
     */
    public static function pay($order_number, $amount, $currency = null, $urls = null): bool;

    /**
     * @return bool
     */
    public static function success(): bool;

    /**
     * @return bool
     */
    public static function notify(): bool;

}