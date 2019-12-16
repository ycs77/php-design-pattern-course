<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\ProductDiscount as ProductDiscountContract;

/**
 * 第X件打折.
 */
class PercentOffSecondItemDiscount implements ProductDiscountContract
{
    /** @var \Ycs77\DesignPattern\Discount\ProductDiscount */
    protected $discount;

    /** @var int */
    protected $percentOff;

    public function __construct(ProductDiscount $discount, float $percentOff)
    {
        $this->discount = $discount;
        $this->percentOff = $percentOff;
    }

    public function calculatePrice(): int
    {
        $price = $this->discount->calculatePrice();
        $count = $this->discount->calculateCount();
        $discountPercent = 1 - $this->percentOff;
        $discountProductCount = floor($this->discount->calculateCount() / 2);

        return $price * ($count - $discountPercent * $discountProductCount);
    }

    public function calculateCount(): float
    {
        return $this->discount->calculateCount();
    }
}
