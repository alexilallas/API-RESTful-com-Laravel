<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HistoricoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Historico');

        foreach (range(1, 8) as $key => $value) {
            DB::table('historicos')->insert([
                'paciente_id' => $faker->numberBetween($min = 1, $max = 15),
                'historico_familiar_id' => $faker->numberBetween($min = 1, $max = 8),
                'historico_pessoal_id' => $faker->numberBetween($min = 1, $max = 8),
            ]);
        }
    }
}
