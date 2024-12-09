<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public $table = 'transactions';

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'total_harga',
        'diskon',
        'bayar',
        'kembali',
        'market_id'
    ];

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->hasMany(OrderItems::class);
    }
}
