<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoPessoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_pessoal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->boolean('fumante');
            $table->integer('quantidade_cigarros')->nullable();
            $table->boolean('alcool');
            $table->integer('frequencia_alcool')->nullable();
            $table->boolean('atividade_fisica');
            $table->string('nome_atividade')->nullable();
            $table->boolean('hipertenso');
            $table->boolean('diabetico');
            $table->string('fator_rh')->nullable();;
            $table->boolean('alergico');
            $table->string('nome_alergia')->nullable();
            $table->boolean('cirurgia');
            $table->string('nome_cirurgia')->nullable();
            $table->boolean('usa_medicamento');
            $table->string('nome_medicamento')->nullable();
            $table->boolean('preventivo_psa')->nullable();
            $table->boolean('vacina_dt');
            $table->boolean('vacina_hb');
            $table->boolean('vacina_fa');
            $table->boolean('vacina_influenza');
            $table->boolean('vacina_antirrabica');
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
        Schema::dropIfExists('historico_pessoal');
    }
}
