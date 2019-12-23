<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{
    protected $fillable = ['batalha_id', 'num_rodada', 'acao',
        'valor_dado_p1', 'valor_dado_p2', 'dano'];
    public $timestamps = false;

    public function batalha()
    {
        return $this->belongsTo(Batalha::class);
    }
}
