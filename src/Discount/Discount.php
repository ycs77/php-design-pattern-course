<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\Discount as DiscountContract;

/**
 * 優惠
 */
class Discount implements DiscountContract
{
    /** @var int */
    protected $price;

    public function __construct(int $price)
    {
        $this->price = $price;
    }

    public function calculatePrice(): int
    {
        return $this->price;
    }
}
