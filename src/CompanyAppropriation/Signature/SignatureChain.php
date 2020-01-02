<?php

namespace Ycs77\DesignPattern\CompanyAppropriation\Signature;

use Closure;

class SignatureChain
{
    /**
     * Create a new signature chain.
     *
     * @param  \Closure  $callback
     * @return \Ycs77\DesignPattern\CompanyAppropriation\Signature\Handler
     */
    public static function create(Closure $callback)
    {
        $signer = new StartSign();

        $callback($signer);

        return $signer;
    }
}
