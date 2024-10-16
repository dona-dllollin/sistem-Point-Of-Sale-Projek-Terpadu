<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'no_karyawan' => '102210023',
            'foto' => 'dsjdhsjd',
            'password' => Hash::make('password123'), // Hash password
            'role' => 'kasir',
            'market_id' => 1
        ]);
    }
}
