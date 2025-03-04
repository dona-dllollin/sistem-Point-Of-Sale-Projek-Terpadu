<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('image');
            $table->string('nama_barang');
            $table->string('satuan')->nullable();
            $table->int('stok');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->foreignId('pemasok_id')->nullable();
            $table->string('keterangan')->default('tersedia');
            $table->foreignId('market_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
