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
        'opciones_fijas',
        'campos_export',
        'num_elem_export',
        'campos_import',
        'campoc',
        'campo0',
    ];
}
