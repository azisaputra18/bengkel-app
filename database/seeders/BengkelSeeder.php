<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Mechanic;

class BengkelSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. SERVICES — sesuai data asli di database
        // =============================================
        $services = [
            [
                'name'           => 'Ketok Magic',
                'specialization' => 'Ketok Magic',
                'duration'       => 4,  // 4 jam
            ],
            [
                'name'           => 'Cat',
                'specialization' => 'Cat',
                'duration'       => 24, // 24 jam (lintas hari)
            ],
            [
                'name'           => 'Ganti Sparepart',
                'specialization' => 'Ganti Sparepart',
                'duration'       => 4,  // 4 jam
            ],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }

        // =============================================
        // 2. MECHANICS — kode auto-generate dari model
        // Ganti nama sesuai nama mekanik asli kamu
        // =============================================
        $mechanics = [
            // Ketok Magic — kode otomatis K1, K2, K3
            ['name' => 'Raden Jiso',      'specialization' => 'Ketok Magic'],

            // Cat — kode otomatis C1, C2, C3
            ['name' => 'Ahmad Yani',      'specialization' => 'Cat'],
          

            // Ganti Sparepart — kode otomatis G1, G2, G3
            ['name' => 'Abah Randik',            'specialization' => 'Ganti Sparepart'],
           
        ];

        foreach ($mechanics as $m) {
            Mechanic::create($m);
        }
    }
}