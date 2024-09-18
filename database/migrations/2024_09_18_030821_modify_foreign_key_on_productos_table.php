<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['category_id']);
            
            // Volver a crear la clave foránea con ON DELETE RESTRICT
            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar la clave foránea con restrict
            $table->dropForeign(['category_id']);
            
            // Volver a crear la clave foránea original (sin restricciones)
            $table->foreign('category_id')
                  ->references('id')->on('categories');
        });
    }
};
