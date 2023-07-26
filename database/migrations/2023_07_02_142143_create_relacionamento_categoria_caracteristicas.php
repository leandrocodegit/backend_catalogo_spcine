<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('caracteristicas', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categoria_caracteristicas');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('caracteristicas', function (Blueprint $table) {
            $table->dropForeign('caracteristicas_categoria_id_foreign');
        });
    }
};
