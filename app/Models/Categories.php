<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    public $table = 'categories';

    protected $fillable = [
        'name',
        'gambar'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'product_id', 'category_id');
    }
}
