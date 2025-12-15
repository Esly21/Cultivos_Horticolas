<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSiembra extends Model
{
    protected $table = 'tipos_siembra';
    protected $primaryKey = 'id_tipo_siembra';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
