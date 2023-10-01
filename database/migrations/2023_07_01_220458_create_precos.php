<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('precos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->boolean('descontos')->nullable()->default(false);
            $table->float('minimo', 10, 2);
            $table->float('maximo', 10, 2);
            $table->string('tabela_descontos')->nullable();
            $table->string('tabela_precos')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('precos');
    }
};
