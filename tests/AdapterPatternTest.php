<?php

namespace Ycs77\DesignPattern\Test;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\AdapterPattern\Cart;
use Ycs77\DesignPattern\AdapterPattern\CashFlow;

class AdapterPatternTest extends TestCase
{
    public function testCheckout()
    {
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface $cashFlow */
        $cashFlow = m::mock(CashFlow::class);
        $cashFlow->shouldReceive('deduction')
            ->with(100)
            ->once();

        $cart = new Cart($cashFlow);
        $cart->setTotal(100);
        $cart->checkout();
    }
}
