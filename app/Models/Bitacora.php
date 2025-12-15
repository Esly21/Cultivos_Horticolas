<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siembra;
class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacoras';

    protected $fillable = [
        'siembra_id',
        'user_id',
        'fecha_seguimiento',
        'crecimiento',
        'observaciones',
        'temperatura_actual',
        'humedad_actual',
    ];

    protected function casts(): array
    {
        return [
            'fecha_seguimiento' => 'date',
        ];
    }

    public function siembra()
    {
       return $this->belongsTo(Siembra::class)
                    ->where('user_id', auth()->id());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
