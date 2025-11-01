<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_number',
        'shop_name',
        'shop_address',
        'city',
        'customer_email',
        'customer_image',
        'shop_image',
        'status',
        'latitude',
        'longitude',
    ];
}
