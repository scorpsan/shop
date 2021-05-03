<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;

class PriorBankOnline implements PaymentMethod
{
    public static function name(): string
    {
        return 'Prior Bank Online';
    }

    public static function pay($order_number, $amount, $currency = null, $urls = null): bool
    {
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

}