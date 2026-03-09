<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'user_id',
        'customer_id',
        'product_id',
        'order_quantity',
        'order_price',
        'order_date',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',
    ];
}
