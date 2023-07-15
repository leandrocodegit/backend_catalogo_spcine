<?php

use App\Models\Enums\StatusAgenda;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected  $statusAgenda = [
        "PENDENTE",
        "CONFIRMADO",
        "AGENDADO",
    ];

    public function up()
    {


        Schema::create('agendas', function (Blueprint $table) {
           $table->unsignedBigInteger('catalogo_id');
           $table->foreign('catalogo_id')->references('id')->on('catalogos');
           $table->date('data');
            $table->enum('status',array_keys(StatusAgenda::cases()))->default(StatusAgenda::PENDENTE->value);
           $table->primary(['catalogo_id', 'data', 'status']);
           $table->unsignedBigInteger('user_id');
           $table->foreign('user_id')->references('id')->on('users');
           $table->float('valor');

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
        Schema::dropIfExists('agenda');
    }
};
