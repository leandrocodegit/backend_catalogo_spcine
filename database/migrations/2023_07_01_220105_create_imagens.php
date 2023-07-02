<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');  
            $table->string('descricao');
            $table->string('link'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagens');
    }
};
