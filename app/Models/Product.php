<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'product_name',
        'product_base_price',
        'unit',
        'status',
        'product_image',
    ];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
