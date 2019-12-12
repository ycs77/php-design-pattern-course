<?php

namespace Ycs77\DesignPattern\Contracts;

interface Discount
{
    public function calculatePrice(): int;
}
