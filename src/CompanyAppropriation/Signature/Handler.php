<?php

namespace Ycs77\DesignPattern\CompanyAppropriation\Signature;

abstract class Handler
{
    /** @var \Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler|null */
    protected $next;

    public function sign(int $price): bool
    {
        if ($this->isSign($price)) {
            if ($this->next) {
                return $this->next->sign($price);
            }

            return true;
        }

        return false;
    }

    public function next(self $next = null): ?self
    {
        if ($next instanceof self) {
            $this->next = $next;
        }

        return $this->next;
    }

    abstract public function isSign(int $price): bool;
}
