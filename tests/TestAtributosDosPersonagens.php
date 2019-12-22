<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class TestAtributosDosPersonagens extends TestCase
{
    /**
     * Testa se os atributos dos personagens Humano e Orc estão corretos.
     *
     * @return void
     */
    public function testAtributosHumano()
    {
        $response = $this->get('/api/attr/humano');

        //TODO: Concluir o teste de acordo com o retorno.
        $this->assertTrue(true);
    }

    public function testAtributosOrc()
    {
        $response = $this->get('/api/attr/orc');

        //TODO: Concluir o teste de acordo com o retorno.
        $this->assertTrue(true);
    }
}
