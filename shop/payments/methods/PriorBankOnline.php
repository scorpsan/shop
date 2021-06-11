<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;
use Yii;

class PriorBankOnline implements PaymentMethod
{
    public static function name(): string
    {
        return 'Prior Bank Online';
    }

    public static function pay($order_number, $amount, $currency = null, $urls = null): array
    {
        return [
            'error' => true,
            'message' => 'Not set',
        ];
    }

    public static function payNow($token): array
    {
        // TODO: Implement payNow() method.
    }

    public static function success($request): array
    {
        return ['status' => self::PAYMENTS_PAID, 'type' => 'success', 'message' => Yii::t('frontend', 'Thank you for paying your order')];
    }

    public static function notify($request): int
    {
        return false;
    }

}