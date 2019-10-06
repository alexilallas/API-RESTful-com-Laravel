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
            $table->boolean('fumante')->nullable();
            $table->integer('quantidade_cigarros')->nullable();
            $table->boolean('alcool')->nullable();
            $table->integer('frequencia_alcool')->nullable();
            $table->boolean('atividade_fisica')->nullable();
            $table->string('nome_atividade')->nullable();
            $table->boolean('hipertenso')->nullable();
            $table->boolean('diabetico')->nullable();
            $table->string('fator_rh')->nullable();;
            $table->boolean('alergico')->nullable();
            $table->string('nome_alergia')->nullable();
            $table->boolean('cirurgia')->nullable();
            $table->string('nome_cirurgia')->nullable();
            $table->boolean('usa_medicamento')->nullable();
            $table->string('nome_medicamento')->nullable();
            $table->boolean('preventivo_psa')->nullable();
            $table->boolean('vacina_dt')->nullable();
            $table->boolean('vacina_hb')->nullable();
            $table->boolean('vacina_fa')->nullable();
            $table->boolean('vacina_influenza')->nullable();
            $table->boolean('vacina_antirrabica')->nullable();
            $table->boolean('mora_sozinho')->nullable();
            $table->boolean('problema_familiar')->nullable();

            $table->boolean('ativo')->default(true);
            $table->integer('versao')->default(1);
            $table->softDeletes();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
