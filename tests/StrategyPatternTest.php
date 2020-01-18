<?php

namespace Ycs77\DesignPattern;

use Exception;
use PHPUnit\Framework\TestCase;
use Ycs77\DesignPattern\Shipping\Calculator;
use Ycs77\DesignPattern\Shipping\ChunghwaPostShippingFee;
use Ycs77\DesignPattern\Shipping\TCatShippingFee;

class StrategyPatternTest extends TestCase
{
    public function tCatDataProvider()
    {
        return [
            [50, 'normal', 130],
            [40, 'low', 160],
            [65, 'normal', 170],
            [80, 'low', 225],
            [110, 'normal', 210],
            [95, 'low', 290],
        ];
    }

    public function chunghwaPostDataProvider()
    {
        return [
            [50, 70],
            [65, 90],
            [110, 110],
            [130, 135],
        ];
    }

    /**
     * 黑貓宅急便.
     *
     * @dataProvider tCatDataProvider
     */
    public function testCalculateShippingFeeForTCat($size, $temperature, $expected)
    {
        $calculator = new Calculator(
            new TCatShippingFee()
        );

        $this->assertSame($expected, $calculator->execute($size, $temperature));
    }

    public function testCalculateShippingFeeForTCatThrowCalculateError()
    {
        $calculator = new Calculator(
            new TCatShippingFee()
        );

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The shipping fee calculate fail');

        $calculator->execute(10000, 'normal');
    }

    public function testCalculateShippingFeeForTCatThrowTemperatureNotFoundError()
    {
        $calculator = new Calculator(
            new TCatShippingFee()
        );

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The package delivery temperature must be "normal" or "low"');

        $calculator->execute(50, 'not-found-temperature');
    }

    /**
     * 郵局 (中華郵政).
     *
     * @dataProvider chunghwaPostDataProvider
     */
    public function testCalculateShippingFeeForChunghwaPost($size, $expected)
    {
        $calculator = new Calculator(
            new ChunghwaPostShippingFee()
        );

        $this->assertSame($expected, $calculator->execute($size));
    }
}
