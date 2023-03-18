<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->foreignId('users_id')->constrained('users');
            $table->string('provincia', 100);
            $table->string('localidad', 100);
            $table->string('direccion', 100);
            $table->string('costo_total', 100);
            $table->dateTime('fecha');
            $table->string('estado', 100);
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
        Schema::dropIfExists('pedidos');
    }
}
