<?php

namespace Ycs77\DesignPattern\Contracts;

interface ProductDiscount extends Discount
{
    public function calculateCount(): float;
}
