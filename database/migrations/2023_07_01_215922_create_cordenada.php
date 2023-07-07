<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('cordenadas', function (Blueprint $table) {
            $table->id();
            $table->string('latitude');
            $table->string('longitute');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cordenadas');
    }
};
