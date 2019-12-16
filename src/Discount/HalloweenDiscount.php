<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\Discount;

/**
 * 萬聖節優惠 打9折.
 */
class HalloweenDiscount implements Discount
{
    /** @var \Ycs77\DesignPattern\Contracts\Discount */
    protected $discount;

    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }

    public function calculatePrice(): int
    {
        return (int) round($this->discount->calculatePrice() * 0.9);
    }
}
