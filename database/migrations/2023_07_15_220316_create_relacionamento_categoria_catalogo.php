<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable();;
            $table->foreign('categoria_id')->references('id')->on('categoria_catalogo');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('catalogos', function (Blueprint $table) {
            $table->dropForeign('catalogos_categoria_id_foreign');
        });
    }
};
