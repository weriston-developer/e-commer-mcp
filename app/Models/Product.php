<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'url_img',
        'name',
        'category',
        'size',
        'price',
        'station',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
