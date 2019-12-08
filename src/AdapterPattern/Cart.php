<?php

namespace Ycs77\DesignPattern\AdapterPattern;

class Cart
{
    /** @var \Ycs77\DesignPattern\AdapterPattern\CashFlow */
    protected $cashFlow;

    /** @var int */
    protected $total;

    public function __construct(CashFlow $cashFlow)
    {
        $this->cashFlow = $cashFlow;
    }

    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    public function checkout()
    {
        $this->cashFlow->deduction($this->total);
    }
}
