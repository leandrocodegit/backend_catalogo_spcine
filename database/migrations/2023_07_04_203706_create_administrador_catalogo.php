<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('administrador_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('active');             
            $table->timestamps();
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('administrador_catalogo');
    }
};
