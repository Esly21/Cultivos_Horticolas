<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Siembra;
use App\Models\TipoUsuario;
use App\Models\Cultivo;
use App\Models\Alerta;
use App\Models\Reporte;
class User extends Authenticatable
{
   use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'password',
        'id_tipo_usuario',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function siembras()
    {
        return $this->hasMany(Siembra::class);
    }
    public function tipoUsuario()
    {
    return $this->belongsTo(TipoUsuario::class, 'id_tipo_usuario');
    }
    public function cultivo(){
        return $this->hasMany(Cultivo::class);
    }
    public function alertas(){
        return $this->hasMany(Alerta::class);
    }
    public function reportes(){
        return $this->hasMany(Reporte::class);
    }
}
