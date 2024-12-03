<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [];

        for ($i = 1; $i <= 10; $i++) {
            $transactions[] = [
                'user_id' => 4, // Sesuaikan dengan ID user yang ada di database
                'kode_transaksi' => Str::upper(Str::random(10)),
                'total_harga' => rand(50000, 200000), // Total harga acak
                'diskon' => 0, // Diskon acak antara 5-20%
                'bayar' => rand(50000, 200000), // Pembayaran acak
                'kembali' => rand(0, 50000), // Kembalian acak
                'market_id' => rand(1, 2), // Sesuaikan dengan ID market yang ada di database
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }
}
