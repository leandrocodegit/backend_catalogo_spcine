<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('precos_catalogo', function (Blueprint $table) {
            $table->unsignedBigInteger('preco_id');
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('preco_id')->references('id')->on('precos');
            $table->foreign('catalogo_id')->references('id')->on('catalogos');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('precos_catalogo', function (Blueprint $table) {
            $table->dropForeign('precos_catalogo_catalogo_id_foreign');
            $table->dropForeign('precos_catalogo_preco_id_foreign');
        }); 

        Schema::dropIfExists('precos_catalogo');
    }
};
