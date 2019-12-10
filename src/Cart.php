<?php

namespace Ycs77\DesignPattern;

class Cart
{
    /** @var \Ycs77\DesignPattern\Product[] */
    protected $items = [];

    /** @var \Ycs77\DesignPattern\CashFlow */
    protected $cashFlow;

    /** @var int */
    protected $total;

    public function __construct(array $items, CashFlow $cashFlow)
    {
        $this->items = $items;
        $this->cashFlow = $cashFlow;
    }

    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getDiscountTotal()
    {
        return $this->total;
    }

    public function checkout()
    {
        $this->cashFlow->deduction($this->total);
    }
}
