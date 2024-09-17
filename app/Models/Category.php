<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

     // Permitir la asignación masiva para estos campos
     protected $fillable = ['name', 'description'];


     protected $guarded = [];
     public $timestamps = false;

     public function productos()
     {
         return $this->hasMany(Producto::class);
     }
}
