<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedentesFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes_familiares', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('diabetes');
            $table->boolean('hipertensao');
            $table->boolean('infarto');
            $table->boolean('morte_subita');
            $table->boolean('cancer');
            $table->string('outro');

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
        Schema::dropIfExists('antecedentes_familiares');
    }
}
