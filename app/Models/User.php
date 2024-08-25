<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'description',
        'image',
        'default_image_path',
        'is_active',
        'last_seen_at',
    ];

    //connect with login devices
    public function login_devices()
    {
        return $this->hasMany(LoginDevice::class);
    }

    //connect with memos
    public function memos()
    {
        return $this->hasMany(Memo::class);
    }

    //connect with chats
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    //connect with friendships
    public function friendships()
    {
        return $this->hasMany(Friendship::class);
    }

    //connect with block lists
    public function block_lists()
    {
        return $this->hasMany(BlockList::class);
    }

    //connect with muted lists
    public function muted_lists()
    {
        return $this->hasMany(MutedList::class);
    }

    //connect with settings
    public function settings()
    {
        return $this->hasOne(Settings::class);
    }
}
