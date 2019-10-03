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
                'hipertenso' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'diabetico' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'fator_rh' => $faker->randomElements($array = array('Positivo','Negativo'), $count = 1)[0],
                'vacina_dt' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'vacina_hb' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'vacina_fa' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'vacina_influenza' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'vacina_antirrabica' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'mora_sozinho' => $faker->randomElements($array = array(true,false), $count = 1)[0],
                'problema_familiar' => $faker->randomElements($array = array(true,false), $count = 1)[0],
            ]);
        }
    }
}
