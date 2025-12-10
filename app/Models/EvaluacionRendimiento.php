<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siembra;
use App\Models\TipoSuelo;
use App\Models\CalidadCosecha;
class EvaluacionRendimiento extends Model
{
    
    use HasFactory;
    protected $table = 'evaluaciones_rendimientos';
    protected $fillable = [
        'siembra_id', 
        'tipo_suelo_id', 
        'fecha_cosecha_real', 
        'dias_transcurridos', 
        'cantidad_cosechada', 
        'unidad_medida',
        'calidad_id', 
        'tamano_promedio', 
        'tipo_cosecha', 
        'observaciones'
    ];

    protected $casts = ['fecha_cosecha_real' => 'date'];

     public function siembra()
    {
        return $this->belongsTo(Siembra::class);
    }

    public function tipoSuelo()
    {
        return $this->belongsTo(TipoSuelo::class);
    }

    public function calidad()
    {
        return $this->belongsTo(CalidadCosecha::class, 'calidad_id');
    }
}
