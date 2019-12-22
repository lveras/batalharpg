<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    public function personagem()
    {
        return $this->belongsTo(Personagem::class);
    }
}
