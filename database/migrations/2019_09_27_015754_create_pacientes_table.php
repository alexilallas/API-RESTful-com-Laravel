<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('cpf_rg');
            $table->enum('estado_civil',['Solteiro(a),Casado(a),Viúvo(a)']);
            $table->string('naturalidade');
            $table->date('data_nascimento');
            $table->enum('sexo',['Masculino','Feminino']);
            $table->unsignedInteger('contato_id');
            $table->foreign('contato_id')->references('id')->on('contatos');

            $table->unsignedInteger('endereco_id');
            $table->foreign('endereco_id')->references('id')->on('enderecos');

            $table->unsignedInteger('exame_fisico_geral_id');
            $table->foreign('exame_fisico_geral_id')->references('id')->on('exame_fisico_gerals');

            $table->unsignedInteger('evolucao_paciente_id');
            $table->foreign('evolucao_paciente_id')->references('id')->on('evolucao_pacientes');

            $table->unsignedInteger('antecedentes_familiares_id');
            $table->foreign('antecedentes_familiares_id')->references('id')->on('antecedentes_familiares');

            $table->unsignedInteger('antecedentes_pessoais_id');
            $table->foreign('antecedentes_pessoais_id')->references('id')->on('antecedente_pessoals');
            
            $table->unsignedInteger('tipo_paciente_id');
            $table->foreign('tipo_paciente_id')->references('id')->on('tipo_pacientes');
            
            
            $table->boolean('ativo')->default(true);
            $table->integer('versao')->default(1);
            $table->boolean('deletado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
