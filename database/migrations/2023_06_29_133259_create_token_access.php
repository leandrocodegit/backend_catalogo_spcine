<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('token_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tipo');
            $table->string('token');
            $table->dateTime('validade');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('token_access');
    }
};
