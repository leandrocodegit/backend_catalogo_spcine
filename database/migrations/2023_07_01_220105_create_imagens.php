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
            $table->string('titulo')->nullable();
            $table->string('descricao')->nullable();
            $table->string('url')->nullable();
            $table->integer('ordem');
            $table->boolean('principal');
            $table->string('originalName')->nullable();
            $table->string('hashName')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagens');
    }
};
