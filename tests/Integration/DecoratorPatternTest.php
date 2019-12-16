<?php

namespace Ycs77\DesignPattern\Test\Integration;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\Cart;
use Ycs77\DesignPattern\CashFlow;
use Ycs77\DesignPattern\Discount\Discount;
use Ycs77\DesignPattern\Discount\HalloweenDiscount;
use Ycs77\DesignPattern\Discount\OverDiscount;
use Ycs77\DesignPattern\Discount\PercentOffDiscount;
use Ycs77\DesignPattern\Product;

class DecoratorPatternTest extends TestCase
{
    /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\Ycs77\DesignPattern\CashFlow $cashFlow */
    protected $cashFlow;

    /** @var \Ycs77\DesignPattern\Product[] */
    protected $products;

    protected function setUp(): void
    {
        $this->cashFlow = m::mock(CashFlow::class);

        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface $cashFlowproduct_1 */
        $product_1 = m::mock(CashFlow::class);
        $product_1->shouldReceive('getPrice')
            ->andReturn(120)
            ->once();
        $product_1->shouldReceive('getCount')
            ->andReturn(1)
            ->once();

        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface $product_2 */
        $product_2 = m::mock(Product::class);
        $product_2->shouldReceive('getPrice')
            ->andReturn(1000)
            ->once();
        $product_2->shouldReceive('getCount')
            ->andReturn(3)
            ->once();

        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface $product_3 */
        $product_3 = m::mock(Product::class);
        $product_3->shouldReceive('getPrice')
            ->andReturn(89)
            ->once();
        $product_3->shouldReceive('getCount')
            ->andReturn(2)
            ->once();

        $this->products = [
            $product_1,
            $product_2,
            $product_3,
        ];
    }

    /**
     * 打7折 (全部商品).
     */
    public function testGetPercentOffDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setDiscount(function ($total) {
            $discount = new Discount($total);
            $discount = new PercentOffDiscount($discount, 0.7);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(2309, $cart->getDiscountTotal());
    }

    /**
     * 滿 2000 優惠 100 (全部商品).
     */
    public function testGetOverDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setDiscount(function ($total) {
            $discount = new Discount($total);
            $discount = new OverDiscount($discount, 2000, 100);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(3198, $cart->getDiscountTotal());
    }

    /**
     * 萬聖節優惠 打9折 (全部商品).
     */
    public function testGetHalloweenDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setDiscount(function ($total) {
            $discount = new Discount($total);
            $discount = new HalloweenDiscount($discount);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(2968, $cart->getDiscountTotal());
    }

    /**
     * 第2件6折 (限同商品).
     */
    public function testGetPercentOffSecondItemDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setProductDiscount(function ($price, $count) {
            $discount = new ProductDiscount($price, $count);
            $discount = new PercentOffSecondItemDiscount($discount, 0.6);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(2862, $cart->getTotal());
    }

    /**
     * 買1送1 (限同商品).
     */
    public function testGetBuyXGetXDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setProductDiscount(function ($price, $count) {
            $discount = new ProductDiscount($price, $count);
            $discount = new BuyXGetXDiscount($discount, 1, 1);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(2209, $cart->getTotal());
    }

    /**
     * 組合折扣.
     *
     * (全部商品)
     * 打8折 + 萬聖節優惠 打9折 + 滿 800 優惠 50
     * +
     * (限同商品)
     * 買2送1
     */
    public function testGetGroupDiscountTotal()
    {
        $cart = new Cart($this->products, $this->cashFlow);

        $cart->setDiscount(function ($total) {
            $discount = new Discount($total);
            $discount = new PercentOffDiscount($discount, 0.8);
            $discount = new HalloweenDiscount($discount);
            $discount = new OverDiscount($discount, 800, 50);

            return $discount;
        });

        $cart->setProductDiscount(function ($price, $count) {
            $discount = new ProductDiscount($price, $count);
            $discount = new BuyXGetXDiscount($discount, 2, 1);

            return $discount;
        });

        $cart->discount();

        $this->assertEquals(2324, $cart->getDiscountTotal());
    }
}
