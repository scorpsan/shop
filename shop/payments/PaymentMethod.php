<?php
namespace shop\payments;

interface PaymentMethod
{
    /**
     * @return string
     */
    public static function name(): string;

    /**
     * @return bool
     */
    public static function pay(): bool;

}