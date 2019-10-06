<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesPerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_permissao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('permissao_id');
            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('cascade');
            $table->unsignedInteger('perfil_id');
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');

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
        Schema::dropIfExists('perfil_permissao');
    }
}
