<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'nama_pengutang',
        'dp',
        'sisa',
        'status'
    ];
    public $table = 'debts';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    
    public function payments()
    {
        return $this->hasMany(DebtPayment::class);
    }

    public function getTotalAngsuranAttribute()
{
    $angsuranLanjutan = $this->payments->sum('jumlah_bayar');
    return $this->dp + $angsuranLanjutan;
}
    

}
