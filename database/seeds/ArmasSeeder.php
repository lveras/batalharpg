<?php

use Illuminate\Database\Seeder;

class ArmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('armas')->insert(
            array(
                array(
                    'nome' => 'Espada Longa',
                    'ataque' => 2,
                    'defesa' => 1,
                    'qnt_lados_dado' => 6,
                    'personagem_id' => DB::table('personagens')
                        ->where('nome', 'Humano')
                        ->pluck('id')[0]
                ),
                array(
                    'nome' => 'Clava',
                    'ataque' => 1,
                    'defesa' => 0,
                    'qnt_lados_dado' => 8,
                    'personagem_id' => DB::table('personagens')
                        ->where('nome', 'Orc')
                        ->pluck('id')[0]
                )
            )
        );
    }
}
