<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_user_id',
        'accept_user_id',
        'is_accepted',
        'type',
    ];


    //connect with user
    public function requestUser()
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }

    //connect with user
    public function acceptUser()
    {
        return $this->belongsTo(User::class, 'accept_user_id');
    }

    //connect with chats
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
