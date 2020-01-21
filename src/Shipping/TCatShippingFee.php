<?php

namespace Ycs77\DesignPattern\Shipping;

use Exception;
use Ycs77\DesignPattern\Contracts\ShippingFee;

class TCatShippingFee implements ShippingFee
{
    /** @see https://www.t-cat.com.tw/inquire/timesheet3.aspx */
    public function calculate(int $size, string $temperature = ''): ?int
    {
        if ($size <= 60) {
            return $this->calcTemperature($temperature, [
                'normal' => 130,
                'low' => 160,
            ]);
        } elseif ($size >= 61 && $size <= 90) {
            return $this->calcTemperature($temperature, [
                'normal' => 170,
                'low' => 225,
            ]);
        } elseif ($size >= 91 && $size <= 120) {
            return $this->calcTemperature($temperature, [
                'normal' => 210,
                'low' => 290,
            ]);
        }

        return null;
    }

    public function calcTemperature(string $temperature, array $temperaturePriceData)
    {
        if (isset($temperaturePriceData[$temperature])) {
            return $temperaturePriceData[$temperature];
        }

        throw new Exception('The package delivery temperature must be "normal" or "low"');
    }
}
