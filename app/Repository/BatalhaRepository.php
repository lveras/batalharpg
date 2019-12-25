<?php


namespace App\Repository;


use App\Personagem;
use App\Rodada;
use Illuminate\Database\Eloquent\Model;


class BatalhaRepository
{
    private $model;
    private $p1;
    private $p2;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->model->load('p1')->load('p2');
        $this->p1 = $this->model->p1->toArray()[0];
        $this->p2 = $this->model->p2->toArray()[0];
    }

    public function vidaRestante(){
        $danos = $this->model->rodadas->where('acao', 3);

        $vida_p1 = $this->p1['vida'] - $danos->where('atacante', $this->p1['id'])
                                             ->sum('valor_dado_p1');

        $vida_p2 = $this->p2['vida'] - $danos->where('atacante', $this->p1['id'])
                                             ->sum('valor_dado_p1');

        return ['p1' => $vida_p1, 'p2' => $vida_p2];
    }

    private function ultimaRodada($acao=false)
    {
        if ($acao) {
            return $this->model->rodadas()->where('acao', $acao)
                ->orderByDesc('id')->first();
        }
        return $this->model->rodadas()->orderByDesc('id')->first();
    }

    private function criaRodada(int $dado1, int $dado2=null, string $acao,
                                int $atacante=null)
    {
        $this->model->load('rodadas');
        $num_rodada = $this->model->rodadas->count()+1;
        $rodada = new Rodada([
            'num_rodada' => $num_rodada,
            'acao' => $acao,
            'valor_dado_p1' => $dado1,
            'valor_dado_p2' => $dado2,
        ]);

        $rodada->atacante = $atacante;
        $this->model->rodadas()->save($rodada);
    }

    private function rolarDado(int $lados): int
    {
        return rand(1, $lados);
    }

    private function iniciativa()
    {
        $p1_agi = $this->p1['agilidade'];
        $p2_agi = $this->p2['agilidade'];

        $dado1 = $p1_agi + $this->rolarDado(20);
        $dado2 = $p2_agi + $this->rolarDado(20);

        while($dado1 == $dado2){
            $this->criaRodada($dado1, $dado2, 1);
            $dado1 = $p1_agi + $this->rolarDado(20);
            $dado2 = $p2_agi + $this->rolarDado(20);
        }

        $this->criaRodada($dado1, $dado2, 'iniciativa');
    }

    private function ataque(Array $p)
    {
        $dado1 = $p[0]['agilidade'] + $this->rolarDado(20) + $p[0]['arma']['ataque'];
        $dado2 = $p[1]['agilidade'] + $this->rolarDado(20) + $p[1]['arma']['ataque'];

        $this->criaRodada($dado1, $dado2, 'ataque', intval($p[0]['id']));
    }

    private function dano(Personagem $atacante){
        $dano = $this->rolarDado($atacante->arma->first()->qnt_lados_dado) +
            $atacante->forca;

        $this->criaRodada($dano, 0, 'dano', $atacante->id);
    }

    private function controlaAcoes()
    {
        $vidas = $this->vidaRestante();
        if (min([$vidas['p1'], $vidas['p2']]) <= 0){
            return $this->model;
        }

        $acao = ($this->model->rodadas->count() != 0) ? $this->ultimaRodada()->acao : 'sem_acao';
        switch ($acao) {
            case 'iniciativa':
                $ult_rodada = $this->ultimaRodada();
                $this->ataque(
                    ($ult_rodada->valor_dado_p1 > $ult_rodada->valor_dado_p2)
                    ? [$this->p1, $this->p2] : [$this->p2, $this->p1]
                );
                break;

            case 'ataque':
                $atacante = (new Personagem())->find($this->ultimaRodada()->atacante);
                $this->dano($atacante);
                break;

            case 'dano':
                $pen_rodada = $this->model->rodadas->where('num_rodada', $this->ultimaRodada()->num_rodada-1)->first();
                if ($pen_rodada->acao == 2){
                    $ult_atacante = $this->ultimaRodada()->atacante;
                    $atacante = (new Personagem())->find(
                        ($ult_atacante == $this->p1['id']) ? $this->p2['id'] : $this->p1['id']
                    );
                    $this->dano($atacante);
                    break;
                }
                $this->iniciativa();
                break;

            case 'sem_acao':
                $this->iniciativa();
        }
    }

    public function getResultado()
    {
        $this->controlaAcoes();
        return $this->model;
    }

}
