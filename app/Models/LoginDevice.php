<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'IMEI',
        'device_name',
        'device_token',
    ];

    //connect with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
