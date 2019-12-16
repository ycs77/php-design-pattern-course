<?php

namespace Ycs77\DesignPattern;

class Product
{
    /** @var int */
    protected $price;

    /** @var int */
    protected $count;

    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }
}
