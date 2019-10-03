<?php

use Illuminate\Database\Seeder;

class EvolucaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker\Generator();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\DateTime($faker));

        foreach (range(1, 10) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'descricao' => $faker->sentence($nbWords = 25, $variableNbWords = true),
            ]);
        }

        foreach (range(1, 8) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'descricao' => $faker->sentence($nbWords = 20, $variableNbWords = true),
            ]);
        }

        foreach (range(1, 6) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'descricao' => $faker->sentence($nbWords = 15, $variableNbWords = true),
            ]);
        }
    }
}
