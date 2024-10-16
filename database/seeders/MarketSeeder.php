<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Market::create([
            'nama_toko' => 'toko gempita',
            'slug' => Str::slug('toko gempita'),
            'no_telp' => '0809828323',
            'alamat' => 'dsjdhsjd',
        ]);
    }
}
