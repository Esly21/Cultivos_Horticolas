<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory; // Buena práctica tenerlo

    protected $table = 'evaluaciones';

    protected $fillable = [
        'user_id',
        'cultivo_id',
        'nombre',
        'notas',
        'siembras_ids',
        'resultado',
    ];

    // ✅ ESTO ES LO QUE ARREGLA EL ERROR DEL PDF (Array to string conversion)
    protected $casts = [
        'siembras_ids' => 'array',
        'resultado'    => 'array',
    ];

    // Relación con Cultivos
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    // ⚠️ FALTA ESTA RELACIÓN (Tu controlador la llama en la función 'historico')
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}