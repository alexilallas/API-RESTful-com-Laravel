<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvolucaoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolucao_pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('descricao');

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
        Schema::dropIfExists('evolucao_pacientes');
    }
}
