<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();;
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('catalogos', function (Blueprint $table) {
            $table->dropForeign('catalogos_user_id_foreign');
        });
    }
};
