<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCultivo;
class Cultivo extends Model
{
    use HasFactory;

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $table = 'cultivos';
    

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
     * Define la relación: Un Cultivo pertenece a un TipoCultivo.
     */
    public function tipoCultivo()
    {
        // Se especifica la clave foránea porque no sigue la convención de Laravel
        return $this->belongsTo(TipoCultivo::class, 'id_tipo_cultivo');
    }
}