<?php
namespace frontend\plugins\payments;

interface PaymentMethod
{
    const STATUS_NEW = 0;
    const STATUS_WAIT = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCEL = 3;
    const STATUS_REFUND = 4;

    /**
     * @return bool
     */
    public function pay(): bool;

    /**
     * @return array
     */
    public function statuses(): array;
}