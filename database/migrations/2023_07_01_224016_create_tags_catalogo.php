<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tags_catalogo', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('catalogo_id');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('catalogo_id')->references('id')->on('catalogos');
   //         $table->primary(['tag_id', 'catalogo_id'])->unique();
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('tags_catalogo', function (Blueprint $table) {
            $table->dropForeign('tags_catalogo_catalogo_id_foreign');
            $table->dropForeign('tags_catalogo_tag_id_foreign');
        });

        Schema::dropIfExists('tags_catalogo');
    }
};
