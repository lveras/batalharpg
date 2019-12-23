<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Personagem;


class FuncionaisTest extends TestCase
{
    /**
     * Testes funcionais
     *
     * @return void
     */

    use DatabaseMigrations;
    use RefreshDatabase;

    public function testAtributosHumano()
    {
        //Verifica os atributos do humano:
        // O humano tem 12 de vida, +1 de força e +2 de agilidade.
        // Possui uma Espada Longa com +2 de ataque, + 1 de defesa
        // e roda um dado de 6 faces.
        $response = $this->get('/api/personagem/1');

        $response->assertJsonStructure(
            ['id', 'nome', 'vida', 'forca', 'agilidade',
                'arma' => ['nome', 'ataque','defesa', 'qnt_lados_dado']])
            ->assertJson([
            "id" => 1,
            "nome" => "Humano",
            "vida" => "12",
            "forca" => "1",
            "agilidade" => "2",
            "arma" => ["id" => 1, "nome" => "Espada Longa",
                "ataque" => "2", "defesa" => "1",
                "qnt_lados_dado" => "6"],

        ]);
    }

    public function testAtributosOrc()
    {
        //Verifica os atributos do orc:
        // O orc tem 20 de vida, +2 de força e +0 de agilidade.
        // Possui uma Clava com +1 de ataque, + 0 de defesa
        // e roda um dado de 8 faces.
        $response = $this->get('/api/personagem/2');

        //Verifica os atributos
        $response->assertJsonStructure(
            ['id', 'nome', 'vida', 'forca', 'agilidade',
                'arma' => ['nome', 'ataque', 'defesa', 'qnt_lados_dado']])
            ->assertJson([
                "id" => 2,
                "nome" => "Orc",
                "vida" => "20",
                "forca" => "2",
                "agilidade" => "0",
                "arma" => ["id" => 2,
                    "nome" => "Clava", "ataque" => "1",
                    "defesa" => "0", "qnt_lados_dado" => "8"],
        ]);
    }

    public function testBatalha()
    {

    }
}
