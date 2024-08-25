<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutedList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'muted_user_id',
    ];

    //connect with chat
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    //connect with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //connect with muted_user
    public function muted_user()
    {
        return $this->belongsTo(User::class, 'muted_user_id');
    }
}
