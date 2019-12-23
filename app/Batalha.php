<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Personagem;
use PhpParser\Node\Scalar\String_;


class Batalha extends Model
{

    protected $fillable = ['token'];
    public $timestamps = false;

    public function rodadas(){
        return $this->hasMany(Rodada::class);
    }

    public function p1(){
        $personagem = (new Personagem())->where('nome', 'Humano')->get();
        $personagem->load('arma');
        return $this->belongsTo(Personagem::class)->withDefault([
            $personagem->toArray()[0]
        ]);
    }

    public function p2(){
        $personagem = (new Personagem())->where('nome', 'Orc')->get();
        $personagem->load('arma');
        return $this->belongsTo(Personagem::class)->withDefault([
            $personagem->toArray()[0]
        ]);
    }
}
