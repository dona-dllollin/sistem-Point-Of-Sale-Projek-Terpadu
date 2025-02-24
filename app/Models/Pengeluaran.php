<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'kategori',
        'deskripsi',
        'jumlah',
    ];

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
