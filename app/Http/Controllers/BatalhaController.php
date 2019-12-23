<?php

namespace App\Http\Controllers;

use App\Personagem;
use App\Batalha;
use App\Rodada;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Array_;

class BatalhaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $batalha = (new Batalha())->create([
            'token' => md5(uniqid(rand(), true))
        ]);
        $batalha->save();

        $batalha->load('p1')
            ->load('p2');

        return response()->json($batalha);
    }

    /**
     * Exibe a batalha de acordo com o token informado
     *
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($token)
    {
        $batalha = (new Batalha())->where('token', $token)->get();
        $batalha->load('p1');
        $batalha->load('p2');
        $batalha->load('rodadas');

        return response()->json($batalha);
    }

    /**
     * Invoca o controlador de rodadas no Model Batalha
     *
     * @param Request $request
     * @param $token
     * @return Response
     */
    public function roll($token){
        $batalha = (new Batalha())
            ->where('token', $token)
            ->first()
            ->load('p1')
            ->load('p2')
            ->load('rodadas')
            ->toArray();

        $this->controlRodadas($batalha);
    }

    private function rolarDado(int $lados)
    {
        return rand(1, $lados);
    }

    private function iniciativa($agi_1, $agi_2)
    {
        $p1 = $agi_1 + $this->rolarDado(20);
        $p2 = $agi_2 + $this->rolarDado(20);

        return [$p1, $p2];
    }

    private function ataque($agi_1, $agi_2, $arma, $defesa)
    {
        $p1 = $agi_1 + $this->rolarDado(20) + $arma;
        $p2 = $agi_2 + $this->rolarDado(20) + $defesa;

        return [$p1, $p2];

    }

    private function cria_rodada($batalha_id, $num_rodada, $acao,
                                 $valor_dado_p1, $valor_dado_p2,
                                 $dano=0){
        (new Rodada())->create([
            'batalha_id' => $batalha_id,
            'num_rodada' => $num_rodada,
            'acao' => $acao,
            'valor_dado_p1' => $valor_dado_p1,
            'valor_dado_p2' => $valor_dado_p2,
            'dano' => $dano
        ])->save();
    }

    private function dano($dano_arma, $lados_dado, $forca){
        return $dano_arma + $this->rolarDado($lados_dado) + $forca;
    }

    private function verificaVida($batalha_id, $token, $p, $vida){
        $dano_sofrido = (new Rodada())->where('batalha_id', $batalha_id)
            ->where('acao', 3)->get()->sum('valor_dado_'.$p);

        if($dano_sofrido >= $vida){
            return $this->show($token);
        }
        else{
            return true;
        }
    }

    private function controlAtaque($atacante, $defensor, $batalha_id, $num_rodada, $token){
        $ataque = $this->ataque($atacante['agilidade'], $defensor['agilidade'],
            $atacante['arma']['ataque'], $defensor['arma']['defesa']);

        $this->cria_rodada($batalha_id, $num_rodada, 2,
            $ataque[0], $ataque[1]);

        if($ataque[0] > $ataque[1]){
            $dano = $this->dano($atacante['arma']['ataque'], $atacante['arma']['qnt_lados_dado'],
                $atacante['forca']);

            $this->cria_rodada($batalha_id, $num_rodada, 3,
                $dano, 0);

            $this->verificaVida($batalha_id, $token, 'p1', $defensor['vida']);
        }

        return true;
    }

    private function controlRodadas($batalha){
        $p1 = $batalha['p1'][0];
        $p2 = $batalha['p2'][0];

        $this->verificaVida($batalha['id'], $batalha['token'], 'p1', $p1['vida']);
        $this->verificaVida($batalha['id'], $batalha['token'], 'p2', $p2['vida']);

        $num_rodada = count($batalha['rodadas'])+1;

        $ini = [0, 0];
        while($ini[1] == $ini[0]){
            $ini = $this->iniciativa($p1['agilidade'], $p2['agilidade']);
            $this->cria_rodada($batalha['id'], $num_rodada,
                1, $ini[0], $ini[1]);
        }

        if($ini[0] > $ini[1]) {
            $this->controlAtaque($p1, $p2, $batalha['id'], $num_rodada, $batalha['token']);
            $this->controlAtaque($p2, $p1, $batalha['id'], $num_rodada, $batalha['token']);
        }
        else{
            $this->controlAtaque($p2, $p1, $batalha['id'], $num_rodada, $batalha['token']);
            $this->controlAtaque($p1, $p2, $batalha['id'], $num_rodada, $batalha['token']);
        }

        return $this->show($batalha['token']);
    }

}
