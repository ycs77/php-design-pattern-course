<?php

namespace Ycs77\DesignPattern\Test;

use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\Discount\BuyXGetXDiscount;
use Ycs77\DesignPattern\Discount\Discount;
use Ycs77\DesignPattern\Discount\HalloweenDiscount;
use Ycs77\DesignPattern\Discount\OverDiscount;
use Ycs77\DesignPattern\Discount\PercentOffDiscount;
use Ycs77\DesignPattern\Discount\PercentOffSecondItemDiscount;
use Ycs77\DesignPattern\Discount\ProductDiscount;

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
     * 萬聖節優惠 打9折 (全部商品).
     */
    public function testCalculateHalloweenDiscountPrice()
    {
        $discount = new Discount(1000);
        $discount = new HalloweenDiscount($discount);

        $this->assertEquals(900, $discount->calculatePrice());
    }

    /**
     * 第2件6折 (限同商品).
     */
    public function testCalculatePercentOffSecondItemDiscountPrice()
    {
        $discount = new ProductDiscount(1000, 2);
        $discount = new PercentOffSecondItemDiscount($discount, 0.6);

        $this->assertEquals(1600, $discount->calculatePrice());
    }

    /**
     * 第2件6折 買3件 (限同商品).
     */
    public function testCalculatePercentOffSecondItemDiscountPriceAndBuyThreeItems()
    {
        $discount = new ProductDiscount(1000, 3);
        $discount = new PercentOffSecondItemDiscount($discount, 0.6);

        $this->assertEquals(2600, $discount->calculatePrice());
    }

    /**
     * 買1送1 (限同商品).
     */
    public function testCalculateBuyXGetXDiscountPrice()
    {
        $discount = new ProductDiscount(1000, 2);
        $discount = new BuyXGetXDiscount($discount, 1, 1);

        $this->assertEquals(1000, $discount->calculatePrice());
    }

    /**
     * 買1送1 買3件 (限同商品).
     */
    public function testCalculateBuyXGetXDiscountPriceAndBuyThreeItems()
    {
        $discount = new ProductDiscount(1000, 3);
        $discount = new BuyXGetXDiscount($discount, 1, 1);

        $this->assertEquals(2000, $discount->calculatePrice());
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
