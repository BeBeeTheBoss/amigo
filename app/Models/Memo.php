<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
        'image',
    ];

    //connect with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
