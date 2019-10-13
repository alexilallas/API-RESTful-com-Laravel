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

        foreach (range(1, 28) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
                'descricao' => $faker->sentence($nbWords = 25, $variableNbWords = true),
                'medico' => $faker->randomElement($array = array ('Dr. Adler Gomes','Dr. José Pedro Jr')),
            ]);
        }

        foreach (range(1, 25) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
                'descricao' => $faker->sentence($nbWords = 20, $variableNbWords = true),
                'medico' => $faker->randomElement($array = array ('Dr. Adler Gomes','Dr. José Pedro Jr')),
            ]);
        }

        foreach (range(1, 15) as $key => $value) {
            DB::table('evolucao_pacientes')->insert([
                'paciente_id' => $value,
                'data' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
                'descricao' => $faker->sentence($nbWords = 15, $variableNbWords = true),
                'medico' => $faker->randomElement($array = array ('Dr. Adler Gomes','Dr. José Pedro Jr')),
            ]);
        }
    }
}
