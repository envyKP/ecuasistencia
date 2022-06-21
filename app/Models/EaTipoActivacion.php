<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaTipoActivacion extends Model
{
    use HasFactory;
    protected $table="ea_tipo_activacion";
    public $timestamps = false;
}
