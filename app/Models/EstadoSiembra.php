<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EstadoSiembra extends Model
{
    use HasFactory;
    protected $table = 'estados_siembra';
    protected $fillable = ['estado'];
}
