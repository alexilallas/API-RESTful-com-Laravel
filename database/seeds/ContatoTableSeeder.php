<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContatoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Contato');

        foreach (range(1, 40) as $key => $value) {
            DB::table('contatos')->insert([
                'nome' => $faker->name,
                'numero' => $faker->numerify('#########'),
                'paciente_id' => $value,
            ]);
        }
    }
}
