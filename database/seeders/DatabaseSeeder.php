<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::factory()->create([
            'name' => 'Azi Saputra',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('Admin123'),
            
        ]);

        // Buat Akun Pegawai
        User::factory()->create([
            'name' => 'Abah',
            'email' => 'pegawai@bengkel.com',
            'password' => Hash::make('Pegawai123'),
           
        ]);

   
        $this->call([
            BengkelSeeder::class,
            UserSeeder::class,
        ]);

        
    }
}