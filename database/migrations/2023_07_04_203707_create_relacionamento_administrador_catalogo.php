<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    { 
            Schema::table('catalogos', function (Blueprint $table) { 
                $table->unsignedBigInteger('administrador_id'); 
                $table->foreign('administrador_id')->references('id')->on('catalogos');
            });
        }
    
        public function down()
        {
            //Removendo relacionamento
            Schema::table('catalogos', function (Blueprint $table) {
                $table->dropForeign('catalogos_administrador_id_foreign'); 
            });      
        }
};

