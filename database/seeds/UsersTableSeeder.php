<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Usuario padrao
        DB::table('users')->insert([
            'name' => 'Alexi',
            'email' => 'user@mail.com',
            'cpf' => 12345678910,
            'password' => bcrypt('123456')
        ]);
        DB::table('perfil_user')->insert([
            'user_id'=> 1,
            'perfil_id'=> 1
        ]);

        //Médico 1
        DB::table('users')->insert([
            'name' => 'Dr. José Pedro Jr',
            'email' => 'user2@mail.com',
            'cpf' => 12345678911,
            'password' => bcrypt('123456')
        ]);
        DB::table('perfil_user')->insert([
            'user_id'=> 2,
            'perfil_id'=> 4
        ]);

        //Médico 2
        DB::table('users')->insert([
            'name' => 'Dr. Adler Gomes',
            'email' => 'user3@mail.com',
            'cpf' => 12345678912,
            'password' => bcrypt('123456')
        ]);
        DB::table('perfil_user')->insert([
            'user_id'=> 3,
            'perfil_id'=> 4
        ]);

        //Enfermeiro 1
        DB::table('users')->insert([
            'name' => 'Lorena Tavares',
            'email' => 'user4@mail.com',
            'cpf' => 12345678913,
            'password' => bcrypt('123456')
        ]);
        DB::table('perfil_user')->insert([
            'user_id'=> 4,
            'perfil_id'=> 3
        ]);

        //Enfermeiro 2
        DB::table('users')->insert([
            'name' => 'Guilherme de Oliveira',
            'email' => 'user5@mail.com',
            'cpf' => 12345678914,
            'password' => bcrypt('123456')
        ]);
        DB::table('perfil_user')->insert([
            'user_id'=> 5,
            'perfil_id'=> 3
        ]);
    }
}
