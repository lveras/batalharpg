<?php

namespace App\Http\Resources;

use App\Repository\BatalhaRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class BatalhaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @param BatalhaRepository $batalha
     * @return array
     */
    public function toArray($request)
    {
        $this->load('p1')->load('p2');

        $p1 = $this->p1->toArray()[0];
        $p2 = $this->p2->toArray()[0];

        $vidas = (new BatalhaRepository($this->resource))
            ->vidaRestante();

        $danos = $this->rodadas->where('acao', 3);
        $vida_p1 = $p1['vida'] - $danos->sum('valor_dado_p1');
        $vida_p2 = $p2['vida'] - $danos->sum('valor_dado_p1');

        return [
            'token' => $this->token,
            $p1['nome'] => $this->p1,
            $p2['nome'] => $this->p2,
            'vida_restante' => [
                $p1['nome'] => $vidas['p1'],
                $p2['nome'] => $vidas['p2'],
            ],
            'rodadas' => $this->rodadas,
        ];
    }
}
