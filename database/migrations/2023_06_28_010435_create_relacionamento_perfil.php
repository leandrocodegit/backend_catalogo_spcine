<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('perfil_id');
            $table->foreign('perfil_id')->references('id')->on('perfil_usuario');
        });
    }
 
    public function down()
    {
         //Removendo relacionamento
         Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_perfil_id_foreign');
        }); 
    }
};
