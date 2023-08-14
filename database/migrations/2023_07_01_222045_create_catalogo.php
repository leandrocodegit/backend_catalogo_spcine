<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->integer('status')->default(1);
            $table->time('hora_inicial')->default('00:00');
            $table->time('hora_final')->default('23:59');
            $table->string('like', 2048);
            $table->string('like_langue', 2048);
            $table->boolean('home')->default(false);
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogos');
    }
};
