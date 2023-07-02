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

        Schema::table('regioes', function (Blueprint $table) {
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('catalogo_id')->references('id')->on('cordenadas');
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

        Schema::table('regioes', function (Blueprint $table) {
            $table->dropForeign('regioes_catalogo_id_foreign');
        });
    }
};
