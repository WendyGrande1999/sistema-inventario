<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;


    // Permitir la asignación masiva para estos campos
    protected $fillable = ['name', 'email', 'contacto', 'phone', 'address'];
}
