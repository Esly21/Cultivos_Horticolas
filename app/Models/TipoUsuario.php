<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipos_usuario';
     protected $primaryKey = 'id'; 
    protected $fillable = [
        'nombre',
    ];
}
