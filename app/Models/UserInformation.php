<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $fillable = [
        'user_id',
        'country',
        'city',
        'address',
        'zip_code',
        'language',
        'is_social_login',
        'social_network_id',
        'social_network_type',
    ];
}
