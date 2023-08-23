<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('regras_catalogo', function (Blueprint $table) {
            $table->unsignedBigInteger('regra_id');
            $table->unsignedBigInteger('catalogo_id');
            $table->primary(['regra_id', 'catalogo_id']);
            $table->foreign('regra_id')->references('id')->on('regras');
            $table->foreign('catalogo_id')->references('id')->on('catalogos');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('regras_catalogo', function (Blueprint $table) {
            $table->dropForeign('regras_catalogo_catalogo_id_foreign');
            $table->dropForeign('regras_catalogo_regra_id_foreign');
        });
        Schema::dropIfExists('regras_catalogo');
    }
};
