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
        Schema::table('salidas', function (Blueprint $table) {
            // Agregar el nuevo campo estado para "activo" o "inactivo"
            $table->string('estado')->default('activo');

            // Eliminar la clave foránea anterior, si existe, para evitar conflictos
            $table->dropForeign(['identrada']);

            // Volver a agregar la clave foránea con la opción de eliminación en cascada
            $table->foreign('identrada')
                  ->references('id')->on('entradas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salidas', function (Blueprint $table) {
            // Eliminar el campo estado
            
          
$table->dropColumn('estado');

            // Volver a agregar la clave foránea sin la opción de cascada
            $table->dropForeign(['identrada']);
            $table->foreign('identrada')
                  ->references('id')->on('entradas');
        });
    }
};
