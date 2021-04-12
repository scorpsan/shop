<?php
namespace frontend\plugins\payments\methods;

use frontend\plugins\payments\PaymentMethod;

class CashOnDelivery implements PaymentMethod
{
    public function pay(): bool
    {
        return false;
    }

    public function statuses(): array
    {
        return [

        ];
    }
}