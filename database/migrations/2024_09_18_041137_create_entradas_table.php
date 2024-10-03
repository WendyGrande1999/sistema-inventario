<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ingreso');
            $table->unsignedBigInteger('idproducto');
            $table->unsignedBigInteger('idproveedor');
            $table->unsignedBigInteger('idusuario');
            $table->integer('cantidad');
            $table->decimal('precio_unidad', 10, 2);
            $table->decimal('saldo_compra', 10, 2);
            $table->timestamps();

            // Definir llaves foráneas con ON DELETE RESTRICT
            $table->foreign('idproducto')->references('id')->on('productos')->onDelete('restrict');
            $table->foreign('idproveedor')->references('id')->on('suppliers')->onDelete('restrict');
            $table->foreign('idusuario')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entradas');
    }
};
