<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah(float|int $amount, bool $symbol = true): string
    {
        $formatted = number_format($amount, 0, ',', '.');
        return $symbol ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('formatDate')) {
    function formatDate(\Carbon\Carbon|string $date, bool $withTime = false): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $carbon = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);
        $result = $carbon->day . ' ' . $months[$carbon->month] . ' ' . $carbon->year;

        if ($withTime) {
            $result .= ', ' . $carbon->format('H:i') . ' WIB';
        }

        return $result;
    }
}

if (!function_exists('formatWeight')) {
    function formatWeight(int $grams): string
    {
        if ($grams >= 1000) {
            $kg = $grams / 1000;
            return number_format($kg, $kg == floor($kg) ? 0 : 1, ',', '.') . ' kg';
        }
        return $grams . ' g';
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber(int|float $num): string
    {
        if ($num >= 1000000) return number_format($num / 1000000, 1) . 'jt';
        if ($num >= 1000) return number_format($num / 1000, 0) . 'rb';
        return (string) $num;
    }
}

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\PlatformSetting::get($key, $default);
    }
}
