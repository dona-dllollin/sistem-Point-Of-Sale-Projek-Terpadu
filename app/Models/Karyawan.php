<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'email',
        'no_karyawan',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'market_id',
    ];
    public $table = 'karyawans';

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
}
