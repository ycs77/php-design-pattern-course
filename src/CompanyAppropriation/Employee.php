<?php

namespace Ycs77\DesignPattern\CompanyAppropriation;

use Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler;

class Employee
{
    public function askPayment(int $price, Handler $handler): bool
    {
        return $handler->sign($price);
    }
}
