<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\Discount;

/**
 * 滿 2000 優惠 100.
 */
class OverDiscount implements Discount
{
    /** @var \Ycs77\DesignPattern\Contracts\Discount */
    protected $discount;

    /** @var int */
    protected $overPrice;

    /** @var int */
    protected $discountPrice;

    public function __construct(Discount $discount, int $overPrice, int $discountPrice)
    {
        $this->discount = $discount;
        $this->overPrice = $overPrice;
        $this->discountPrice = $discountPrice;
    }

    public function calculatePrice(): int
    {
        if ($this->discount->calculatePrice() >= $this->overPrice) {
            return $this->discount->calculatePrice() - $this->discountPrice;
        }

        return $this->discount->calculatePrice();
    }
}
