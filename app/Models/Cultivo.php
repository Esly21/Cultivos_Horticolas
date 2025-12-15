<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCultivo;
use App\Models\User;
use App\Models\Siembra;
use App\Models\TipoSiembra;
use App\Models\Periodo;
use App\Models\Rango;
use App\Models\Dimension;
class Cultivo extends Model
{
    use HasFactory;

    protected $table = 'cultivos';

    protected $fillable = [
    'nombre_cientifico',
    'nombre_comun',
    'descripcion',
    'imagen',
    'id_tipo_cultivo',
    'id_tipo_siembra',
    'id_periodo',
    'id_rango',
    'id_dimension',
    'tiempo_cosecha',
    'tiempo_riego',
    'profundidad_semilla',
    'iluminacion',
    'costo',
    'sector',
    'parcela',
    'cantidad_de_plantas',
    'user_id'
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
        return $this->hasMany(Siembra::class, 'cultivo_id', 'id')
                    ->where('user_id', auth()->id());
    }
    public function tipoSiembra()
    {
        return $this->belongsTo(TipoSiembra::class, 'id_tipo_siembra');
    }
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
    public function rango()
    {
        return $this->belongsTo(Rango::class, 'id_rango'); 
    }
    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'id_dimension'); 
    }
}
