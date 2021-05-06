<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileDevice extends Model
{
    protected $fillable = [
        'user_id',
        'device_type',
        'device_token'
    ];
}
