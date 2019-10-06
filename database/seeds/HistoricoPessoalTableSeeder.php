<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HistoricoPessoalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\HistoricoPessoal');

        foreach (range(1, 8) as $key => $value) {
            DB::table('historico_pessoal')->insert([
                'paciente_id' => $value,
                'fumante' => false,
                'hipertenso' => $faker->randomElement($array = array(true,false), $count = 1),
                'diabetico' => $faker->randomElement($array = array(true,false), $count = 1),
                'fator_rh' => $faker->randomElement($array = array('Positivo','Negativo'), $count = 1),
                'vacina_dt' => $faker->randomElement($array = array(true,false), $count = 1),
                'vacina_hb' => $faker->randomElement($array = array(true,false), $count = 1),
                'vacina_fa' => $faker->randomElement($array = array(true,false), $count = 1),
                'vacina_influenza' => $faker->randomElement($array = array(true,false), $count = 1),
                'vacina_antirrabica' => $faker->randomElement($array = array(true,false), $count = 1),
                'mora_sozinho' => $faker->randomElement($array = array(true,false), $count = 1),
                'problema_familiar' => $faker->randomElement($array = array(true,false), $count = 1),
            ]);
        }
    }
}
