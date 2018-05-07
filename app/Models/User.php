<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function friends()
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id');
    }

    public function outgoingFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'from_id');
    }

    public function incomingFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'to_id');
    }

    public function transactionsFrom()
    {
        return $this->hasMany(Transaction::class, 'from_id');
    }

    public function transactionsTo()
    {
        return $this->hasMany(Transaction::class, 'to_id');
    }

    public function obligationsFrom()
    {
        return $this->hasMany(Obligation::class, 'from_id');
    }

    public function obligationsTo()
    {
        return $this->hasMany(Obligation::class, 'to_id');
    }
}
