<?php

namespace App\Models;

use Auth;
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

    public function hasObligationToCurrentUser()
    {
        $obligation = $this->obligationsFrom()->where('to_id', Auth::user()->id)->first();

        return $obligation != null && $obligation->amount > 0.0;
    }

    public function hasObligationFromCurrentUser()
    {
        $obligation = $this->obligationsTo()->where('from_id', Auth::user()->id)->first();

        return $obligation != null && $obligation->amount > 0.0;
    }

    public function getObligationToCurrentUser()
    {
        return $this->obligationsFrom()->where('to_id', Auth::user()->id)->first();
    }

    public function getObligationFromCurrentUser()
    {
        return $this->obligationsTo()->where('from_id', Auth::user()->id)->first();
    }
}
