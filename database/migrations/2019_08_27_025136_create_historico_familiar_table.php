<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoFamiliarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_familiar', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('diabetes')->nullable();
            $table->boolean('hipertensao')->nullable();
            $table->boolean('infarto')->nullable();
            $table->boolean('morte_subita')->nullable();
            $table->boolean('cancer')->nullable();
            $table->string('outro')->nullable();

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
        Schema::dropIfExists('historico_familiar');
    }
}
