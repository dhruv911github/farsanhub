<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'order_quantity',
        'order_price',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
