<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Dimension extends Model
{
    use HasFactory;
    protected $table = 'dimensiones'; // Nombre de tu tabla en la BD
    protected $primaryKey = 'id_dimension';
    protected $fillable = ['largo', 'ancho', 'altura'];

}
