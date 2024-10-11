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
        Schema::table('entradas', function (Blueprint $table) {
            // Agregar el campo cantidad_entrante como un entero
            $table->integer('cantidad_entrante')->nullable()->after('cantidad');
            
            // Agregar el campo estado como un string para representar el estado de la entrada
            $table->string('estado')->default('activo')->after('cantidad_entrante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('entradas', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn('cantidad_entrante');
            $table->dropColumn('estado');
        });
    }
};
