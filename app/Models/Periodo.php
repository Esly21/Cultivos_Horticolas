<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Periodo extends Model
{
    use HasFactory;
    protected $table = 'periodos'; // Nombre de tu tabla en la BD
    protected $primaryKey = 'id_periodo';
    protected $fillable = ['nombre'];
}
