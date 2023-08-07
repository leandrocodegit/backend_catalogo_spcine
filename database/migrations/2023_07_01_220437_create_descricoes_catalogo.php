<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('descricoes_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('descricao', 2048)->nullable();
            $table->boolean('destaque')->nullable()->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('descricoes_catalogo');
    }
};
