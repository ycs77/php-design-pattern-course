<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\ProductDiscount as ProductDiscountContract;

/**
 * 買X送X.
 */
class BuyXGetXDiscount implements ProductDiscountContract
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
        $discountProductCount = floor($this->discount->calculateCount() / 2);

        return $price * ($count - $discountProductCount);
    }

    public function calculateCount(): float
    {
        return $this->discount->calculateCount();
    }
}
