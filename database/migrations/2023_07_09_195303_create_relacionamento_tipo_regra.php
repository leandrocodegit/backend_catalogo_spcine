<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::table('regras', function (Blueprint $table) { 
            $table->unsignedBigInteger('tipo_id')->nullable();; 
            $table->foreign('tipo_id')->references('id')->on('tipo_regra');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('regras', function (Blueprint $table) {
            $table->dropForeign('regras_tipo_id_foreign'); 
        });      
    }
};
