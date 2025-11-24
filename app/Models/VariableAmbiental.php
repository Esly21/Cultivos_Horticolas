<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siembra;
class VariableAmbiental extends Model
{
   use HasFactory;
    protected $table = 'variables_ambientales';

    // Añadimos los nuevos campos a $fillable
    protected $fillable = [
        'siembra_id',
        'temperatura',
        'humedad',
        'luminosidad_lux',
        'ph_suelo',
        'fecha_hora',
        'humedad_charola1',
        'humedad_charola2',
        'humedad_charola3',
        'humedad_charola4',
        'ventilador_activo',
        'riego_activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
        ];
    }

    public function siembra()
    {
        return $this->belongsTo(Siembra::class);
    }
}