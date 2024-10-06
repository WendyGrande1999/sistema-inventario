<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_salida',
        'idproducto',
        'idusuario',
        'unidad_medida',
        'cantidad',
    ];

    protected $dates = ['fecha_salida']; // Define el atributo como una instancia de Carbon

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
}

