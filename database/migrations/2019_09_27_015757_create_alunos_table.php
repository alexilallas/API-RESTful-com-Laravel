<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->unsignedInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->boolean('ativo')->default(true);
            $table->integer('versao')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('alunos');
    }
}
