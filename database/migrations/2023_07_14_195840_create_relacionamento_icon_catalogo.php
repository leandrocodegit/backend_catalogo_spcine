<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->unsignedBigInteger('icon_id')->nullable();;
            $table->foreign('icon_id')->references('id')->on('icon_cordenada');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('catalogos', function (Blueprint $table) {
            $table->dropForeign('catalogos_icon_id_foreign');
        });
    }
};
