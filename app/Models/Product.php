<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'unit',
        'unit_amount',
        'price',
        'in_stock',
        'image',
        'product_discount',
        'tax_percentage'
    ];
}
