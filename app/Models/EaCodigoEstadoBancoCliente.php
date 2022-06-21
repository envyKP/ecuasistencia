<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaCodigoEstadoBancoCliente extends Model
{
    use HasFactory;
    protected $table = "ea_codigo_estado_banco_cliente";
    public $timestamps = false;
}
