<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountShare extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
