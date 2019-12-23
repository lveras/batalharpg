<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personagem extends Model
{
    protected $table = 'personagens';
    protected $guarded = [];

    public function arma(){
        return $this->hasOne(Arma::class);
    }

    public function batalhas(){
        return $this->hasMany(Batalha::class);
    }
}

