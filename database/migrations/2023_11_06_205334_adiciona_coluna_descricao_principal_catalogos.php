<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->string('descricao_principal', 2048)->nullable()->default('');
        });
    }

    public function down()
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->dropColumn('descricao_principal');
        });
    }
};
