<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->string('documento',45)->unique()->nullable();
            $table->string('email')->unique();
            $table->string('telefone', 25)->nullable();
            $table->string('celular', 25)->nullable();
            $table->boolean('email_verificado')->default(false);
            $table->string('empresa', 45)->nullable()->nullable();
            $table->string('password')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
