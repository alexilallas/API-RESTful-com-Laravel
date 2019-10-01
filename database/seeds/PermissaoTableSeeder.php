<?php

use Illuminate\Database\Seeder;

class PermissaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissoes')->insert([
            'nome'=>'visualizarDashboard',
            'descricao'=> 'Pode visualizar a Dashboard'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarPaciente',
            'descricao'=> 'Pode adicionar Paciente'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarPaciente',
            'descricao'=> 'Pode editar paciente'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarHistoricoMedico',
            'descricao'=> 'Pode criar Histórico Médico'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarHistoricoMedico',
            'descricao'=> 'Pode editar histórico Médico'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarExameFisico',
            'descricao'=> 'Pode criar Exame Físico'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarExameFisico',
            'descricao'=> 'Pode editar Exame Físico'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarEvolucao',
            'descricao'=> 'Pode criar Evolução'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarEvolucao',
            'descricao'=> 'Pode editar Evolução'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'visualizarProntuario',
            'descricao'=> 'Pode visualizar Prontuario'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarItem',
            'descricao'=> 'Pode criar item no Inventário'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarItem',
            'descricao'=> 'Pode editar item no Inventário'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'criarUsuario',
            'descricao'=> 'Pode criar usuários no sistema'
        ]);

        DB::table('permissoes')->insert([
            'nome'=>'editarUsuario',
            'descricao'=> 'Pode editar usuários do sistema'
        ]);
    }
}
