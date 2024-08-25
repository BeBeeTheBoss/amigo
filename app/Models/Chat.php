<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'friendship_id',
        'chat_wallpaper',
    ];

    //connect with friendship
    public function friendship()
    {
        return $this->belongsTo(Friendship::class, 'friendship_id');
    }

    //connect with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //connect with block_list
    public function block_list()
    {
        return $this->hasOne(BlockList::class);
    }

    //connect with muted_list
    public function muted_list()
    {
        return $this->hasOne(MutedList::class);
    }
}
