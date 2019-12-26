<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRodadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rodadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batalha_id');
            $table->integer('num_rodada');
            $table->integer('acao');
            $table->integer('valor_dado_p1');
            $table->integer('valor_dado_p2');
            $table->integer('atacante')->nullable();
            $table->foreign('batalha_id')
                ->references('id')
                ->on('batalhas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rodadas');
    }
}
