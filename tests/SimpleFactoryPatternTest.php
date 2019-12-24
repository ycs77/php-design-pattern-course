<?php

namespace Ycs77\DesignPattern\Test;

use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\Discount\Discount;
use Ycs77\DesignPattern\Discount\SimpleFactory as DiscountSimpleFactory;

class SimpleFactoryPatternTest extends TestCase
{
    public function testCreateDiscountUseSimpleFactory()
    {
        $discount = DiscountSimpleFactory::createDiscount(0);

        $this->assertInstanceOf(Discount::class, $discount);
    }
}
