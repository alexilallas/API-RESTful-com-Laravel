<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissaoTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(PacienteTableSeeder::class);
        $this->call(ContatoTableSeeder::class);

        $this->call(HistoricoFamiliarTableSeeder::class);
        $this->call(HistoricoPessoalTableSeeder::class);

        $this->call(ExameFisicoTableSeeder::class);
        $this->call(EvolucaoTableSeeder::class);

        $this->call(InventarioTableSeeder::class);
    }
}
