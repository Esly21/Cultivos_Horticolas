<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\VariableAmbiental;
use App\Models\Alerta;
use App\Models\User;
use App\Models\Cultivo;
use App\Models\EstadoSiembra;
use App\Models\Bitacora;
use App\Models\Evaluacion;
use App\Models\Cosecha;
class Siembra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cultivo_id',
        'estado_siembra_id',
        'fecha_inicio',
        'fecha_cosecha_estimada',
        'notas',
        'inversion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio'           => 'date',
            'fecha_cosecha_estimada' => 'date',
        ];
    }

    // ================= RELACIONES =================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔒 RELACIÓN SEGURA
     * Solo devuelve el cultivo si pertenece al usuario autenticado
     */
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id', 'id')
                    ->where('user_id', auth()->id());
    }

    public function estadoSiembra()
    {
        return $this->belongsTo(EstadoSiembra::class);
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }

    public function variablesAmbientales()
    {
        return $this->hasMany(VariableAmbiental::class, 'siembra_id', 'id');
    }

    public function ultimaLectura()
    {
        return $this->hasOne(VariableAmbiental::class, 'siembra_id', 'id')
                    ->latestOfMany('fecha_hora');
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'siembra_id', 'id');
    }

    public function cosechas()
    {
        // Asumiendo que tienes un modelo llamado Cosecha en App\Models\Cosecha
        return $this->hasMany(Cosechas::class, 'siembra_id', 'id');
    }
    public function evaluacion()
    {
        return $this->hasOne(Evaluacion::class, 'siembras_ids', 'id')
                    ->where('user_id', auth()->id());
    }   
}
