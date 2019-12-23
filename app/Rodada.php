<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{
    public function batalha()
    {
        return $this->belongsTo(Batalha::class);
    }
}
