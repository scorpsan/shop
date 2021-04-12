<?php
namespace frontend\plugins\payments\methods;

use frontend\plugins\payments\PaymentMethod;

class AlfaBankOnline implements PaymentMethod
{
    /**
     * URL API платежного шлюза
     */
    const RBS_PROD_URL = 'https://ecom.alfabank.by/payment/rest/';
    const RBS_TEST_URL = 'https://web.rbsuat.com/ab_by/rest/';

    public function pay(): bool
    {
        return true;
    }

    public function statuses(): array
    {
        return [

        ];
    }

    public function continue()
    {

    }
}