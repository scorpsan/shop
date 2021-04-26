<?php
namespace shop\payments\methods;

use shop\payments\PaymentMethod;

class PriorBankOnline implements PaymentMethod
{
    /**
     * URL API платежного шлюза
     */
    //const RBS_PROD_URL = 'https://ecom.alfabank.by/payment/rest/';
    //const RBS_TEST_URL = 'https://web.rbsuat.com/ab_by/rest/';

    public static function name(): string
    {
        return 'Prior Bank Online';
    }

    public static function pay(): bool
    {
        return true;
    }

}