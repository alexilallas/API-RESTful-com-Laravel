<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HistoricoFamiliarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\HistoricoFamiliar');

        foreach (range(1, 8) as $key => $value) {
            DB::table('historico_familiar')->insert([
                'paciente_id' => $value,
                'diabetes' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'hipertensao' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'infarto' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'morte_subita' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'cancer' => $faker->randomElements($array = array(true,false), $count = 1)[0],
            ]);
        }
    }
}
