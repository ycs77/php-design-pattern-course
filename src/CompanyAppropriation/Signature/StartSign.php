<?php

namespace Ycs77\DesignPattern\CompanyAppropriation\Signature;

class StartSign extends Handler
{
    public function isSign(int $price): bool
    {
        return true;
    }
}
