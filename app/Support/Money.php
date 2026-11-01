<?php

namespace App\Support;

class Money
{
    /** 185000 -> "Rp 185.000" */
    public static function rp(int|float|null $amount): string
    {
        return 'Rp ' . number_format((int) $amount, 0, ',', '.');
    }
}
