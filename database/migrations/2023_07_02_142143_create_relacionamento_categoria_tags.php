<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_tag_id');
            $table->foreign('categoria_tag_id')->references('id')->on('categoria_tags');
        });
    }

    public function down()
    {
        //Removendo relacionamento
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign('tags_categoria_tag_id_foreign');
        });
    }
};
