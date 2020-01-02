<?php

namespace Ycs77\DesignPattern\Test;

use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\Discount\Discount;
use Ycs77\DesignPattern\Discount\HalloweenDiscount;
use Ycs77\DesignPattern\Discount\OverDiscount;
use Ycs77\DesignPattern\Discount\PercentOffDiscount;

class DecoratorPatternTest extends TestCase
{
    /**
     * 打7折 (全部商品).
     */
    public function testCalculatePercentOffDiscountPrice()
    {
        $discount = new Discount(1000);
        $discount = new PercentOffDiscount($discount, 0.7);

        $this->assertEquals(700, $discount->calculatePrice());
    }

    /**
     * 滿 2000 優惠 100 (全部商品).
     */
    public function testCalculateOverDiscountPrice()
    {
        $discount = new Discount(2400);
        $discount = new OverDiscount($discount, 2000, 100);

        $this->assertEquals(2300, $discount->calculatePrice());
    }

    /**
     * 滿 2000 優惠 100, 但未達金額時就不計算優惠金額 (全部商品).
     */
    public function testCalculateOverDiscountPriceButAmountNotReached()
    {
        $discount = new Discount(1900);
        $discount = new OverDiscount($discount, 2000, 100);

        $this->assertEquals(1900, $discount->calculatePrice());
    }

    /**
     * 萬聖節優惠 打9折 (全部商品).
     */
    public function testCalculateHalloweenDiscountPrice()
    {
        $discount = new Discount(1000);
        $discount = new HalloweenDiscount($discount);

        $this->assertEquals(900, $discount->calculatePrice());
    }

    /**
     * 組合折扣.
     *
     * (全部商品)
     * 打8折 + 萬聖節優惠 打9折 + 滿 800 優惠 50
     */
    public function testCalculateGroupDiscountPrice()
    {
        $discount = new Discount(3000);
        $discount = new PercentOffDiscount($discount, 0.8);
        $discount = new HalloweenDiscount($discount);
        $discount = new OverDiscount($discount, 2000, 100);

        $this->assertEquals(2060, $discount->calculatePrice());
    }
}
