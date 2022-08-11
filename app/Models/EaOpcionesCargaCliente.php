<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaOpcionesCargaCliente extends Model
{
    use HasFactory;
    protected $table = "ea_opciones_carga_cliente";
    public $timestamps = false;

    protected $fillable = [
        'codigo_id',
        'cliente',
        'tipo_subproducto',
        'subproducto',
        'opciones_validacion',
    ];
}
