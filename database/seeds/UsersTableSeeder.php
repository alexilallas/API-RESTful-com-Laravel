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
        DB::table('users')->insert([
            'name' => 'Alexi',
            'email' => 'user@mail.com',
            'password' => bcrypt('123456')
        ]);

        DB::table('perfil_user')->insert([
            'user_id'=> 1,
            'perfil_id'=> 1
        ]);
    }
}
