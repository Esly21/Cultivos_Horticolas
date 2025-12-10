<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TipoSuelo extends Model
{
    use HasFactory;
    protected $table = 'tipos_suelos';
    protected $fillable = ['nombre'];

}
