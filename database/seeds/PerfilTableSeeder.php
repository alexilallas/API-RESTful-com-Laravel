<?php

use Illuminate\Database\Seeder;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfis')->insert([
            'nome'=>'MASTER',
            'descricao'=> 'Acesso total ao sistema'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Administrador',
            'descricao'=> 'Acesso total ao sistema'
        ]);


        DB::table('perfis')->insert([
            'nome'=>'Atendente',
            'descricao'=> 'Pode adicionar/editar pacientes e histórico médico'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Médico',
            'descricao'=> 'Pode adicionar/editar evolução'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Enfermeiro',
            'descricao'=> 'Pode adicionar/editar exame físico'
        ]);

        //Perfil Master
        foreach (range(1, 13) as $permissao) {
            DB::table('perfil_permissao')->insert([
                'perfil_id'=> 1,
                'permissao_id'=> $permissao
            ]);
        }
    }
}
