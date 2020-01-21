<?php

namespace Ycs77\DesignPattern\Shipping;

use Exception;
use Ycs77\DesignPattern\Contracts\ShippingFee;

class Calculator
{
    /** @var \Ycs77\DesignPattern\Contracts\ShippingFee */
    protected $shippingFee;

    public function __construct(ShippingFee $shippingFee)
    {
        $this->shippingFee = $shippingFee;
    }

    public function execute(int $size, string $temperature = ''): int
    {
        $price = $this->shippingFee->calculate($size, $temperature);

        if (is_int($price)) {
            return $price;
        }

        throw new Exception('The shipping fee calculate fail');
    }
}
