<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function shares()
    {
        return $this->hasMany(AccountShare::class);
    }
}
