<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'price',
        'total_tax',
        'coupon_id',
        'final_price',
        'status',
        'delivery_charge',
        'payment_method_id',
        'coupon_discount'
    ];
}
