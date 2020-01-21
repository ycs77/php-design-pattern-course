<?php

namespace Ycs77\DesignPattern\Shipping;

use Ycs77\DesignPattern\Contracts\ShippingFee;

class ChunghwaPostShippingFee implements ShippingFee
{
    /**
     * @see https://www.post.gov.tw/post/internet/Postal/index.jsp?ID=2050106
     * 二.普通資費 （客戶通知到府收件以外箱尺寸計算）
     */
    public function calculate(int $size, string $temperature = ''): ?int
    {
        if ($size <= 60) {
            return 70;
        } elseif ($size >= 61 && $size <= 90) {
            return 90;
        } elseif ($size >= 91 && $size <= 120) {
            return 110;
        } elseif ($size >= 121 && $size <= 150) {
            return 135;
        }

        return null;
    }
}
