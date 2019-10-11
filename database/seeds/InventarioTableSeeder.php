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
        $medicamentos = [
            'ZIAGEN','ORENCIA','SECTRAL','TYLENOL','GLIBENCLAMIDA',
            'CLORIDRATO DE METFORMINA','DIPROPIONATO DE BECLOMETSONA','BUDESONIDA','CAPTOPRIL',
            'GLIBENCLAMIDA','SINVASTATINA','ATENOLOL','ASPIRINA','MILRIDONA','PROVIGIL','VIVITROL',
            'ALOCRIL','NITROGLICERINA','TERCONAZOL','VALPROATO','PARACETAMOL'
        ];

        foreach ($medicamentos as $key => $medicamento) {
            DB::table('inventario')->insert([
                'nome' => strtoupper($medicamento),
                'tipo' => $faker->randomElement($array = array('Injetável', 'Oral'), $count = 1),
                'dose' => $faker->numberBetween($min = 3, $max = 25),
                'descricao' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }
    }
}
