<?php

namespace Ycs77\DesignPattern\Test;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\SignatureChain;
use Ycs77\DesignPattern\CompanyAppropriation\Signature\StartSign;

class ChainOfResponsibilityTest extends TestCase
{
    public function testSignPass()
    {
        $firstHandler = m::mock(Handler::class . '[isSign]');
        $firstHandler->shouldReceive('isSign')
            ->with(10000)
            ->once()
            ->andReturn(true);

        $secondHandler = m::mock(Handler::class . '[isSign]');
        $secondHandler->shouldReceive('isSign')
            ->with(10000)
            ->once()
            ->andReturn(true);

        $firstHandler->next($secondHandler);

        $this->assertTrue($firstHandler->sign(10000));
    }

    public function testSignFail()
    {
        $firstHandler = m::mock(Handler::class . '[isSign]');
        $firstHandler->shouldReceive('isSign')
            ->with(10000)
            ->once()
            ->andReturn(true);

        $secondHandler = m::mock(Handler::class . '[isSign]');
        $secondHandler->shouldReceive('isSign')
            ->with(10000)
            ->once()
            ->andReturn(false);

        $firstHandler->next($secondHandler);

        $this->assertFalse($firstHandler->sign(10000));
    }

    public function testSetAndGetNextSignatureHandler()
    {
        $firstHandler = m::mock(Handler::class . '[isSign]');
        $secondHandler = m::mock(Handler::class . '[isSign]');

        $this->assertNull($firstHandler->next());
        $this->assertSame($secondHandler, $firstHandler->next($secondHandler));
        $this->assertSame($secondHandler, $firstHandler->next());
    }

    public function testCreateChain()
    {
        /** @var \Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler|\Mockery\MockInterface|\Mockery\LegacyMockInterface $mock */
        $mock = m::mock(Handler::class . '[isSign]');
        $mock->shouldReceive('isSign')
            ->with(10000)
            ->once()
            ->andReturn(true)
            ->getMock();

        $chain = SignatureChain::create(function (Handler $chain) use ($mock) {
            $chain->next($mock);
        });

        $this->assertInstanceOf(StartSign::class, $chain);

        $chain = $chain->next();
        $this->assertSame($mock, $chain);

        $chain = $chain->next();
        $this->assertNull($chain);
    }
}
