<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siembra;
class Alerta extends Model
{
    use HasFactory;

    protected $fillable = [
        'siembra_id',
        'mensaje',
        'severidad',
        'fecha',
        'leida',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    public function siembra()
    {
        return $this->belongsTo(Siembra::class);
    }
}
