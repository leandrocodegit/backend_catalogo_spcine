<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    { 
            Schema::table('descricoes_catalogo', function (Blueprint $table) { 
                $table->unsignedBigInteger('catalogo_id'); 
                $table->foreign('catalogo_id')->references('id')->on('catalogos');
            });
        }
    
        public function down()
        {
            //Removendo relacionamento
            Schema::table('descricoes_catalogo', function (Blueprint $table) {
                $table->dropForeign('descricoes_catalogo_catalogo_id_foreign'); 
            });      
        }
};

