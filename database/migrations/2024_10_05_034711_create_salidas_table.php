<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_salida');
            $table->unsignedBigInteger('idproducto');
            $table->unsignedBigInteger('idusuario');
            $table->string('unidad_medida');
            $table->integer('cantidad');
            $table->timestamps();

            // Llaves foránea
            $table->foreign('idproducto')->references('id')->on('productos')->onDelete('restrict');
            $table->foreign('idusuario')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
