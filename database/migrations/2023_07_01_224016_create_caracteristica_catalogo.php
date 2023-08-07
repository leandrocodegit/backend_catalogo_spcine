<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('caracteristicas_catalogo', function (Blueprint $table) {
            $table->unsignedBigInteger('caracteristica_id');
            $table->unsignedBigInteger('catalogo_id');
            $table->primary(['catalogo_id', 'caracteristica_id']);
            $table->foreign('caracteristica_id')->references('id')->on('caracteristicas');
            $table->foreign('catalogo_id')->references('id')->on('catalogos');

   //         $table->primary(['tag_id', 'catalogo_id'])->unique();
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('caracteristicas_catalogo', function (Blueprint $table) {
            $table->dropForeign('tags_catalogo_catalogo_id_foreign');
            $table->dropForeign('tags_catalogo_caracteristica_id_foreign');
        });

        Schema::dropIfExists('caracteristicas_catalogo');
    }
};
