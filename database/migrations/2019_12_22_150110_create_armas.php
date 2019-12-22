<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->integer('ataque');
            $table->integer('defesa');
            $table->integer('qnt_lados_dado');
            $table->timestamps();
        });

        DB::table('armas')->insert(
            array(
                array(
                    'nome' => 'Espada Longa',
                    'ataque' => 2,
                    'defesa' => 1,
                    'qnt_lados_dado' => 6,
                ),
                array(
                    'nome' => 'Clava',
                    'ataque' => 1,
                    'defesa' => 0,
                    'qnt_lados_dado' => 8
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('armas');
    }
}
