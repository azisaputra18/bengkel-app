<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mechanic;
use App\Models\Service;

class BengkelSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. SEED DATA LAYANAN (SERVICES) ---
        // Pastikan Nama Service sama persis dengan Spesialisasi Mekanik
        $services = [
            [
                'name' => 'Ketok Magic',
                'duration' => 120 // 2 Jam
            ],
            [
                'name' => 'Cat',
                'duration' => 180 // 3 Jam
            ],
            [
                'name' => 'Ganti Sparepart',
                'duration' => 60 // 1 Jam
            ],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }

        // --- 2. SEED DATA MEKANIK (MECHANICS) ---
        $mechanics = [
            // Spesialis Ketok Magic
            ['name' => 'K1 (Ketok)', 'specialization' => 'Ketok Magic'],
            ['name' => 'K2 (Ketok)', 'specialization' => 'Ketok Magic'],
            ['name' => 'K3 (Ketok)', 'specialization' => 'Ketok Magic'],
            
            // Spesialis Cat
            ['name' => 'C1 (Paint)', 'specialization' => 'Cat'],
            ['name' => 'C2 (Paint)', 'specialization' => 'Cat'],
            ['name' => 'C3 (Paint)', 'specialization' => 'Cat'],
            
            // Spesialis Sparepart
            ['name' => 'S1 (Part)', 'specialization' => 'Ganti Sparepart'],
            ['name' => 'S2 (Part)', 'specialization' => 'Ganti Sparepart'],
            ['name' => 'S3 (Part)', 'specialization' => 'Ganti Sparepart'],
        ];

        foreach ($mechanics as $m) {
            Mechanic::create($m);
        }
    }
}
