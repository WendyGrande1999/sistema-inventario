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
        Schema::table('productos', function (Blueprint $table) {
            // Agregar el nuevo campo 'imagen'
            $table->string('imagen')->nullable(); // Puedes usar 'nullable' si deseas que sea opcional
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar el campo 'imagen' en caso de revertir la migración
            $table->dropColumn('imagen');
        });
    }
};
