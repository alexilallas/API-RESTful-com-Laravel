<?php

use Illuminate\Database\Seeder;

class InventarioTableSeeder extends Seeder
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
        $faker->addProvider(new Faker\Provider\Base($faker));

        foreach (range(1, 15) as $key => $value) {
            DB::table('inventario')->insert([
                'nome' => $faker->word,
                'tipo' => $faker->randomElement($array = array('Injetável', 'Oral'), $count = 1),
                'quantidade' => $faker->numberBetween($min = 3, $max = 25),
                'descricao' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }
    }
}
