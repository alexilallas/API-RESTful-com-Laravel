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
                'diabetes' => $faker->randomElement($array = array(true,false), $count = 1),
                'hipertensao' => $faker->randomElement($array = array(true,false), $count = 1),
                'infarto' => $faker->randomElement($array = array(true,false), $count = 1),
                'morte_subita' => $faker->randomElement($array = array(true,false), $count = 1),
                'cancer' => $faker->randomElement($array = array(true,false), $count = 1),
            ]);
        }
    }
}
