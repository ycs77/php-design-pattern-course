<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\Discount;

/**
 * 打折.
 */
class PercentOffDiscount implements Discount
{
    /** @var \Ycs77\DesignPattern\Contracts\Discount */
    protected $discount;

    /** @var float */
    protected $percentOff;

    public function __construct(Discount $discount, float $percentOff)
    {
        $this->discount = $discount;
        $this->percentOff = $percentOff;
    }

    public function calculatePrice(): int
    {
        return (int) round($this->discount->calculatePrice() * $this->percentOff);
    }
}
