<?php

namespace Ycs77\DesignPattern\Discount;

use Ycs77\DesignPattern\Contracts\ProductDiscount as ProductDiscountContract;

/**
 * 商品優惠.
 */
class ProductDiscount implements ProductDiscountContract
{
    /** @var int */
    protected $price;

    /** @var int */
    protected $count;

    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    public function calculatePrice(): int
    {
        return $this->price;
    }

    public function calculateCount(): float
    {
        return $this->count;
    }
}
