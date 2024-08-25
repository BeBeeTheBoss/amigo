<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dark_mode',
        'notifications',
        'busy_mode',
        'hide_profile',
    ];

    //connect with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
