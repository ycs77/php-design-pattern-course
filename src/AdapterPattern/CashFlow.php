<?php

namespace Ycs77\DesignPattern\AdapterPattern;

interface CashFlow
{
    public function deduction(int $price);
}
