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
        $cashFlow = m::mock(CashFlow::class);
        $cashFlow->shouldReceive('deduction')->with(100);

        $cart = new Cart($cashFlow);
        $cart->setTotal(100);
        $cart->checkout();
    }
}
