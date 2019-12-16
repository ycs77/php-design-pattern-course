<?php

namespace Ycs77\DesignPattern\Discount;

class SimpleFactory
{
    public static function createDiscount(int $price)
    {
        return new Discount($price);
    }
}
