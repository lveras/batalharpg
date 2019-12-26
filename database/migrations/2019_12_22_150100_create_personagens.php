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
