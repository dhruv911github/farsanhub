<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'upload_date'
    ];

    protected $casts = [
        'upload_date' => 'date'
    ];
}
