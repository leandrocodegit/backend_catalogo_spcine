<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('catalogo_id')->references('id')->on('imagens');
        });

        Schema::table('cordenadas', function (Blueprint $table) {
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('catalogo_id')->references('id')->on('cordenadas');
        });

        Schema::table('catalogos', function (Blueprint $table) {
            $table->unsignedBigInteger('regiao_id');
            $table->foreign('regiao_id')->references('id')->on('regioes');
        });

        Schema::table('precos', function (Blueprint $table) {
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('catalogo_id')->references('id')->on('precos');
        });
    }

    public function down()
    {
        //Removendo relacionamento imagens
        Schema::table('imagens', function (Blueprint $table) {
            $table->dropForeign('imagens_catalogo_id_foreign');
        });

        Schema::table('cordenadas', function (Blueprint $table) {
            $table->dropForeign('cordenadas_catalogo_id_foreign');
        });

        Schema::table('catalogos', function (Blueprint $table) {
            $table->dropForeign('catalogos_regiao_id_foreign');
        });

        Schema::table('precos', function (Blueprint $table) {
            $table->dropForeign('precos_catalogo_id_foreign');
        });
    }
};
