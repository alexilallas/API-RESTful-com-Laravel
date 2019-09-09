<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedentePessoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_pessoals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->boolean('fumante');
            $table->integer('quantidade_cigarros');
            $table->boolean('alcool');
            $table->integer('frequencia_alcool');
            $table->boolean('atividade_fisica');
            $table->string('nome_atividade');
            $table->boolean('hipertenso');
            $table->boolean('diabetico');
            $table->enum('fator_rh',['Positivo','Negativo']);
            $table->boolean('alergia');
            $table->string('nome_alergia');
            $table->boolean('cirurgia');
            $table->string('nome_cirurgia');
            $table->boolean('usa_medicamento');
            $table->string('nome_medicamento');
            $table->boolean('preventivo_psa');
            $table->boolean('vacina_dt');
            $table->boolean('vacina_hb');
            $table->boolean('vacina_fa');
            $table->boolean('vacina_influenza');
            $table->boolean('vacina_antirabica');
            $table->boolean('mora_sozinho');
            $table->boolean('problema_familiar');

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
        Schema::dropIfExists('antecedente_pessoals');
    }
}
