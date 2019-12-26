<?php

use Illuminate\Database\Seeder;

class PersonagensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
}
