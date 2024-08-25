<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'blocked_user_id',
    ];

    //connect with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //connect with chat
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    //connect with blocked user
    public function blocked_user()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
