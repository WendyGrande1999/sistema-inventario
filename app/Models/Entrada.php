<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Entrada extends Model
{
    use HasFactory;

     // Definir los campos que se pueden asignar en masa
     protected $fillable = [
        'fecha_ingreso',
        'idproducto',
        'idproveedor',
        'idusuario',
        'unidad_medida',
        'cantidad',
        'cantidad_entrante',
        'estado',
        'precio_unidad',
        'saldo_compra'
    ];


    protected $dates = ['fecha_ingreso']; // Define el atributo como una instancia de Carbon
    // Definir la relación con el modelo Producto

    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }

    // Definir la relación con el modelo Supplier
    public function proveedor()
    {
        return $this->belongsTo(Supplier::class, 'idproveedor');
    }

    // Definir la relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function salidas()
    {
    return $this->hasMany(Salida::class, 'identrada');
    }

     // Evento deleting para eliminar las salidas asociadas
     protected static function boot()
     {
         parent::boot();
 
         static::deleting(function ($entrada) {
             // Eliminar las salidas relacionadas con esta entrada
             $entrada->salidas()->delete();
         });
     }

}
