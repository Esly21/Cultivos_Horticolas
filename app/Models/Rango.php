<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Rango extends Model
{
    use HasFactory;
    protected $table = 'rangos'; // Nombre de tu tabla en la BD
    protected $fillable = ['nombre'];
}
