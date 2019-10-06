<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExameFisicoGeralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exame_fisico_geral', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('data');
            $table->string('pressao');
            $table->float('altura');
            $table->float('peso');
            $table->float('glicemia');
            $table->float('temperatura');
            $table->integer('frequencia_cardiaca');
            $table->integer('frequencia_respiratoria');

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
        Schema::dropIfExists('exame_fisico_geral');
    }
}
