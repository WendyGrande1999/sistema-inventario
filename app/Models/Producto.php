<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'category_id'];

    // Relación con categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}