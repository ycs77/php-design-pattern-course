<?php

namespace Ycs77\DesignPattern;

class Cart
{
    /** @var \Ycs77\DesignPattern\Product[] */
    protected $items = [];

    /** @var \Ycs77\DesignPattern\CashFlow */
    protected $cashFlow;

    /** @var \Ycs77\DesignPattern\Contracts\Discount */
    protected $discount;

    /** @var int */
    protected $total = 0;

    /** @var int */
    protected $discountTotal = 0;

    public function __construct(array $items, CashFlow $cashFlow)
    {
        $this->items = $items;
        $this->cashFlow = $cashFlow;
        $this->calcTotalFromproducts();
    }

    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function calcTotalFromproducts()
    {
        /** @var \Ycs77\DesignPattern\Product $product */
        foreach ($this->items as $product) {
            $this->total += $product->getPrice() * $product->getCount();
        }
    }

    public function setDiscount(callable $callback)
    {
        $this->discount = $callback($this->total);
    }

    public function discount()
    {
        $this->discountTotal = $this->discount->calculatePrice();
    }

    public function getDiscountTotal()
    {
        return $this->discountTotal;
    }

    public function checkout()
    {
        $this->cashFlow->deduction($this->total);
    }
}
