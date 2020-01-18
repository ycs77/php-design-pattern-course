<?php

namespace Ycs77\DesignPattern\Contracts;

interface ShippingFee
{
    public function calculate(int $size, string $temperature = ''): ?int;
}
