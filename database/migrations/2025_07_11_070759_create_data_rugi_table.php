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
        Schema::create('data_rugi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('total_kerugian', 15, 2);
            $table->string('alasan')->nullable(); // rusak / kadaluarsa / hilang
            $table->timestamp('tanggal')->useCurrent();
            $table->foreignId('user_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rugi');
    }
};
