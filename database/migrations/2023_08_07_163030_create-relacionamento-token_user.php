<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('token_access', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('token_access', function (Blueprint $table) {
            $table->dropForeign('token_access_user_id_foreign');
        });
    }
};
