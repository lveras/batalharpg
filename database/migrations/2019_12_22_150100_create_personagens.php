<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personagens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nome')->unique();
            $table->integer('vida');
            $table->integer('forca');
            $table->integer('agilidade');
        });

        DB::table('personagens')->insert(
            [
                array(
                    'nome' => 'Humano',
                    'vida' => 12,
                    'forca' => 1,
                    'agilidade' => 2,
                ),
                array(
                    'nome' => 'Orc',
                    'vida' => 20,
                    'forca' => 2,
                    'agilidade' => 0,
                )
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personagens');
    }
}
