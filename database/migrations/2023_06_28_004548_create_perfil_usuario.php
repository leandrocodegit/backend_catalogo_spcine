<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('perfil_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('role', 6);
            $table->string('nome', 20 );
            $table->timestamps();
        });

     
    }
 
    public function down()
    {  
        //Removendo tabela
        Schema::dropIfExists('perfil_usuario');
    }
};
