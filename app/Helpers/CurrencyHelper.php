<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function rupiah(float $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}