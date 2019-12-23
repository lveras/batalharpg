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

    private function rolarDado(int $lados)
    {
        return rand(1, $lados);
    }

    private function iniciativa()
    {
        $p1 = $this->p1->agilidade + $this->rolarDado(20);
        $p2 = $this->p2->agilidade + $this->rolarDado(20);

        return [$this->p1->nome => $p1, $this->p2->nome => $p2];
    }

    private function ataque()
    {

    }

    public function controlRodadas(){
        switch ($this->acao){
            case 0:
                // Incrementa rodada
                $num_rodada = count($this->rodada_list);
                $this->rodada_list[$num_rodada] = [
                    'iniciativa' => array(),
                    'ataque' => array(),
                    'dano' => array(),
                ];

                array_push($this->rodada_list[$num_rodada]['iniciativa'],
                    $this->iniciativa());

                return $this->rodada_list;

                break;

            case 1:
                return FALSE;
                break;

            default:
                throw new \Exception('Valor inesperado');

        }
    }




















}
