<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Market extends Model
{

    public $table = 'markets';
    use HasFactory;

    // public function user(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }
}
