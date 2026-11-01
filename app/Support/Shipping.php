<?php

namespace App\Support;

class Shipping
{
    public static function normalize(?string $text): string
    {
        return mb_strtolower(trim(preg_replace('/\s+/', ' ', (string) $text)));
    }

    public static function isDomestic(?string $country): bool
    {
        return self::normalize($country) === self::normalize(config('shop.home_country'));
    }

    /** Apakah metode pengiriman ini boleh dipakai untuk negara dan kota tersebut */
    public static function isAvailable(string $key, ?string $country, ?string $city): bool
    {
        $method = config("shop.shipping_methods.$key");
        if (! $method) {
            return false;
        }

        $domestic = self::isDomestic($country);

        if (($method['scope'] ?? 'domestic') === 'international') {
            return ! $domestic;
        }

        if (! $domestic) {
            return false;
        }

        if (! empty($method['only_cities'])) {
            return in_array(self::normalize($city), $method['only_cities'], true);
        }

        return true;
    }

    public static function cost(string $key, int $subtotal): int
    {
        $method = config("shop.shipping_methods.$key");
        if (! $method) {
            return 0;
        }

        $freeMin = config('shop.free_shipping_min');
        if (($method['scope'] ?? 'domestic') === 'domestic' && $freeMin !== null && $subtotal >= $freeMin) {
            return 0;
        }

        return (int) $method['cost'];
    }

    /** COD hanya untuk kota tertentu di dalam negeri */
    public static function codAvailable(?string $country, ?string $city): bool
    {
        return self::isDomestic($country)
            && in_array(self::normalize($city), (array) config('shop.cod_cities'), true);
    }
}
