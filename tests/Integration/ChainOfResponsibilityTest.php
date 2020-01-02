<?php

namespace Ycs77\DesignPattern\Test\Integration;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\CompanyAppropriation\Employee;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\AdvancedSupervisorSign;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\GeneralManagerSign;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\SignatureChain;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\StartSign;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\SupervisorSign;

class ChainOfResponsibilityTest extends TestCase
{
    public function assertChain(array $expected, Handler $signatureChain)
    {
        $this->assertInstanceOf(StartSign::class, $signatureChain);

        foreach ($expected as $class) {
            $signatureChain = $signatureChain->next();
            $this->assertInstanceOf($class, $signatureChain);
        }

        $signatureChain = $signatureChain->next();
        $this->assertNull($signatureChain);
    }

    public function testAskForPaymentPassed()
    {
        $price = 10000;

        $signatureChain = SignatureChain::create(function (Handler $chain) {
            $chain
                ->next(new SupervisorSign)
                ->next(new AdvancedSupervisorSign)
                ->next(new GeneralManagerSign);
        });

        $lucas = new Employee();

        $canPayment = $lucas->askPayment($price, $signatureChain);

        $this->assertChain([
            SupervisorSign::class,
            AdvancedSupervisorSign::class,
            GeneralManagerSign::class,
        ], $signatureChain);

        $this->assertTrue($canPayment);
    }

    public function testAskForPaymentFailFromSupervisorSign()
    {
        $price = 10000;

        $mock = m::mock(SupervisorSign::class . '[isSign]')
            ->shouldReceive('isSign')
            ->with($price)
            ->once()
            ->andReturn(false)
            ->getMock();

        $signatureChain = SignatureChain::create(function (Handler $chain) use ($mock) {
            $chain
                ->next($mock)
                ->next(new AdvancedSupervisorSign)
                ->next(new GeneralManagerSign);
        });

        $canPayment = (new Employee())->askPayment($price, $signatureChain);

        $this->assertChain([
            SupervisorSign::class,
            AdvancedSupervisorSign::class,
            GeneralManagerSign::class,
        ], $signatureChain);

        $this->assertFalse($canPayment);
    }

    public function testAskForPaymentFailFromAdvancedSupervisorSign()
    {
        $price = 10000;

        $mock = m::mock(AdvancedSupervisorSign::class . '[isSign]')
            ->shouldReceive('isSign')
            ->with($price)
            ->once()
            ->andReturn(false)
            ->getMock();

        $signatureChain = SignatureChain::create(function (Handler $chain) use ($mock) {
            $chain
                ->next(new SupervisorSign)
                ->next($mock)
                ->next(new GeneralManagerSign);
        });

        $canPayment = (new Employee())->askPayment($price, $signatureChain);

        $this->assertChain([
            SupervisorSign::class,
            AdvancedSupervisorSign::class,
            GeneralManagerSign::class,
        ], $signatureChain);

        $this->assertFalse($canPayment);
    }

    public function testAskForPaymentFailFromGeneralManagerSign()
    {
        $price = 10000;

        $mock = m::mock(GeneralManagerSign::class . '[isSign]')
            ->shouldReceive('isSign')
            ->with($price)
            ->once()
            ->andReturn(false)
            ->getMock();

        $signatureChain = SignatureChain::create(function (Handler $chain) use ($mock) {
            $chain
                ->next(new SupervisorSign)
                ->next(new AdvancedSupervisorSign)
                ->next($mock);
        });

        $canPayment = (new Employee())->askPayment($price, $signatureChain);

        $this->assertChain([
            SupervisorSign::class,
            AdvancedSupervisorSign::class,
            GeneralManagerSign::class,
        ], $signatureChain);

        $this->assertFalse($canPayment);
    }
}
