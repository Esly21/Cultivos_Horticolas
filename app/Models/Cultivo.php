<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCultivo;
use App\Models\User;
use App\Models\Siembra;

class Cultivo extends Model
{
    use HasFactory;

    protected $table = 'cultivos';

    protected $fillable = [
        'user_id',
        'nombre_cientifico',
        'nombre_comun',
        'descripcion',
        'imagen',
        'id_tipo_cultivo',
        'tiempo_riego',
        'tiempo_cosecha',
        'id_tipo_siembra',
        'profundidad_semilla',
        'iluminacion',
        'costo',
        'sector',
        'parcela',
        'id_periodo',
        'cantidad_de_plantas',
        'id_rango',
        'id_dimension',
    ];

    /**
     * Relación: Un cultivo pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Un cultivo pertenece a un tipo de cultivo.
     */
    public function tipoCultivo()
    {
        return $this->belongsTo(TipoCultivo::class, 'id_tipo_cultivo');
    }

    /**
     * Relación opcional: Un cultivo tiene muchas siembras.
     */
    public function siembras()
    {
        return $this->hasMany(Siembra::class, 'cultivo_id');
    }
}
