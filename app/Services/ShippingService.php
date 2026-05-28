<?php

namespace App\Services;

class ShippingService
{
    // Dummy couriers for development
    private array $couriers = ['jne', 'jnt', 'sicepat', 'pos'];

    private array $services = [
        'jne'     => [
            ['service' => 'REG', 'description' => 'JNE Reguler', 'cost' => 12000, 'etd' => '2-3'],
            ['service' => 'OKE', 'description' => 'JNE Oke',     'cost' => 9000,  'etd' => '3-5'],
            ['service' => 'YES', 'description' => 'JNE Yes',     'cost' => 26000, 'etd' => '1-1'],
        ],
        'jnt'     => [
            ['service' => 'EZ',  'description' => 'J&T Express', 'cost' => 11000, 'etd' => '2-3'],
            ['service' => 'ECO', 'description' => 'J&T Eco',     'cost' => 8000,  'etd' => '4-5'],
        ],
        'sicepat' => [
            ['service' => 'BEST', 'description' => 'SiCepat Best', 'cost' => 10000, 'etd' => '2-3'],
            ['service' => 'HALU', 'description' => 'SiCepat Halu', 'cost' => 25000, 'etd' => '1-1'],
        ],
        'pos'     => [
            ['service' => 'Pos Reguler', 'description' => 'Pos Reguler', 'cost' => 8000, 'etd' => '3-5'],
        ],
    ];

    public function getCosts(string $origin, string $destination, int $weight, string $courier = null): array
    {
        $couriers = $courier ? [$courier] : $this->couriers;
        $results  = [];

        // Weight factor (per 1000g)
        $weightFactor = max(1, ceil($weight / 1000));

        foreach ($couriers as $c) {
            if (!isset($this->services[$c])) continue;

            $results[$c] = array_map(function ($svc) use ($weightFactor) {
                return [
                    'service'     => $svc['service'],
                    'description' => $svc['description'],
                    'cost'        => $svc['cost'] * $weightFactor,
                    'etd'         => $svc['etd'] . ' hari',
                ];
            }, $this->services[$c]);
        }

        return $results;
    }

    public function getProvinces(): array
    {
        return [
            ['id' => '11', 'name' => 'Aceh'],
            ['id' => '12', 'name' => 'Sumatera Utara'],
            ['id' => '13', 'name' => 'Sumatera Barat'],
            ['id' => '14', 'name' => 'Riau'],
            ['id' => '15', 'name' => 'Jambi'],
            ['id' => '16', 'name' => 'Sumatera Selatan'],
            ['id' => '17', 'name' => 'Bengkulu'],
            ['id' => '18', 'name' => 'Lampung'],
            ['id' => '19', 'name' => 'Kepulauan Bangka Belitung'],
            ['id' => '21', 'name' => 'Kepulauan Riau'],
            ['id' => '31', 'name' => 'DKI Jakarta'],
            ['id' => '32', 'name' => 'Jawa Barat'],
            ['id' => '33', 'name' => 'Jawa Tengah'],
            ['id' => '34', 'name' => 'DI Yogyakarta'],
            ['id' => '35', 'name' => 'Jawa Timur'],
            ['id' => '36', 'name' => 'Banten'],
            ['id' => '51', 'name' => 'Bali'],
            ['id' => '52', 'name' => 'Nusa Tenggara Barat'],
            ['id' => '53', 'name' => 'Nusa Tenggara Timur'],
            ['id' => '61', 'name' => 'Kalimantan Barat'],
            ['id' => '62', 'name' => 'Kalimantan Tengah'],
            ['id' => '63', 'name' => 'Kalimantan Selatan'],
            ['id' => '64', 'name' => 'Kalimantan Timur'],
            ['id' => '65', 'name' => 'Kalimantan Utara'],
            ['id' => '71', 'name' => 'Sulawesi Utara'],
            ['id' => '72', 'name' => 'Sulawesi Tengah'],
            ['id' => '73', 'name' => 'Sulawesi Selatan'],
            ['id' => '74', 'name' => 'Sulawesi Tenggara'],
            ['id' => '75', 'name' => 'Gorontalo'],
            ['id' => '76', 'name' => 'Sulawesi Barat'],
            ['id' => '81', 'name' => 'Maluku'],
            ['id' => '82', 'name' => 'Maluku Utara'],
            ['id' => '91', 'name' => 'Papua Barat'],
            ['id' => '94', 'name' => 'Papua'],
        ];
    }

    public function getCourierLabel(string $courier): string
    {
        return match($courier) {
            'jne'     => 'JNE',
            'jnt'     => 'J&T Express',
            'sicepat' => 'SiCepat',
            'pos'     => 'Pos Indonesia',
            default   => strtoupper($courier),
        };
    }
}
