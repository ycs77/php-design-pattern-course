<?php

namespace Ycs77\DesignPattern\CompanyAppropriation\Signature;

class SupervisorSign extends Handler
{
    public function isSign(int $price): bool
    {
        // some logic

        return true;
    }
}
