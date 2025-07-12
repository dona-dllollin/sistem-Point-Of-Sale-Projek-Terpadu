<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rugi extends Model
{
    use HasFactory;
    protected $table = 'data_rugi';

      protected $fillable = [
        'kode_barang',
        'jumlah',
        'harga_beli',
        'total_kerugian',
        'alasan',
        'tanggal',
        'user_id',
        'nama_barang'
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
