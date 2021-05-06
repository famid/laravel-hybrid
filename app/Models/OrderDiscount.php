<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $fillable = [
        'min_order_price',
        'discount_percentage',
        'status'
    ];
}
