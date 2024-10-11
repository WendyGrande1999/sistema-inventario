<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CierreInventario extends Model
{
    use HasFactory;

    protected $table = 'cierres_inventario';
    protected $fecha_cierre = ['fecha_cierre'];
    protected $fillable = ['producto_id', 'cantidad_total', 'fecha_cierre'];

    
   

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
