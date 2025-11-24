<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\VariableAmbiental; // 👈 Asegúrate de importar el modelo
use App\Models\Alerta; // opcional, solo si ya existe
use App\Models\User;
use App\Models\Cultivo;
use App\Models\EstadoSiembra;
use App\Models\Bitacora;
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

    // === Relaciones existentes ===
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id', 'id');
    }

    public function estadoSiembra()
    {
        return $this->belongsTo(EstadoSiembra::class);
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }

    // === NUEVO: relación con variables ambientales ===
    public function variablesAmbientales()
    {
        return $this->hasMany(VariableAmbiental::class, 'siembra_id', 'id');
    }

    // === NUEVO: última lectura (para el monitoreo) ===
    public function ultimaLectura()
    {
        // Usa fecha_hora como campo de orden
        return $this->hasOne(VariableAmbiental::class, 'siembra_id', 'id')
                    ->latestOfMany('fecha_hora');
    }

    // (Opcional) si tienes un modelo Alerta
    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'siembra_id', 'id');
    }
}