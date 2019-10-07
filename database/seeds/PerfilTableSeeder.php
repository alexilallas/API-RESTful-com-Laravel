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
            'nome'=>'Administrador',
            'descricao'=> 'Acesso total ao sistema'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Atendente',
            'descricao'=> 'Pode adicionar/editar pacientes e histórico médico'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Enfermeiro',
            'descricao'=> 'Pode adicionar/editar exame físico'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Médico',
            'descricao'=> 'Pode adicionar/editar evolução'
        ]);

        DB::table('perfis')->insert([
            'nome'=>'Farmacêutico',
            'descricao'=> 'Pode adicionar/editar evolução'
        ]);


        //Perfil Administrador -> todas as permissões
        foreach (range(1, 15) as $permissao) {
            DB::table('perfil_permissao')->insert([
                'perfil_id'=> 1,
                'permissao_id'=> $permissao
            ]);
        }

        //Perfil Atendente -> Criar/Editar Paciente/Histórico  e Visualizar Prontuário/Dashboard
        foreach (range(1, 5) as $permissao) {
            DB::table('perfil_permissao')->insert([
                'perfil_id'=> 2,
                'permissao_id'=> $permissao
            ]);
        }
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 2,
            'permissao_id'=> 10
        ]);

        //Perfil Enfermeiro -> Criar/Editar ExameFísico/ItemInventário e Visualizar Prontuário/Dashboard
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 1
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 6
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 7
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 10
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 11
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 3,
            'permissao_id'=> 12
        ]);

        //Perfil Médico -> Criar/Editar Evolução/ItemInventário e Visualizar Prontuário/Dashboard
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 4,
            'permissao_id'=> 1
        ]);
        foreach (range(8, 12) as $permissao) {
            DB::table('perfil_permissao')->insert([
                'perfil_id'=> 4,
                'permissao_id'=> $permissao
            ]);
        }

        //Perfil Farmacêutico -> Criar/Editar Itens do inventário e Visualizar Dashboard
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 5,
            'permissao_id'=> 1
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 5,
            'permissao_id'=> 11
        ]);
        DB::table('perfil_permissao')->insert([
            'perfil_id'=> 5,
            'permissao_id'=> 12
        ]);
    }
}
