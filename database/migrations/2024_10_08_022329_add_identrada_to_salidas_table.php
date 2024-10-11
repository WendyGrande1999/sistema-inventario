<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('salidas', function (Blueprint $table) {
            $table->unsignedBigInteger('identrada')->nullable(); // Agregamos el campo identrada
            $table->foreign('identrada')->references('id')->on('entradas')->onDelete('restrict'); // Relación foránea con entradas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('salidas', function (Blueprint $table) {
            $table->dropForeign(['identrada']); // Eliminamos la clave foránea
            $table->dropColumn('identrada'); // Eliminamos el campo
        });
    }
};
