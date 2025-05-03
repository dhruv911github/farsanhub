<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_name',
        'gu_name',
        'en_post',
        'gu_post',
        'en_description',
        'gu_description',
        'image',
        'status'
    ];
}
