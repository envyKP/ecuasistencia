<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaCabeceraDetalleCarga extends Model
{
    use HasFactory;
    protected $table = "ea_cabecera_detalle_carga";
    public $timestamps = false;

    protected $fillable = [
        'cod_carga',
        'proceso',
        'cliente',
        'producto',
        'desc_producto',
        'fec_carga',
        'archivo',
        'custom_code',
        'n_custom_code',
        'total_registros_disponibles_gestion',
        'total_registros_aceptan',
        'total_otros_call_types',
        'usuario_registra',
        'fec_registro',
        'estado',
        'visible',
        'is_det_debito',
        'subproducto_id',
        'usuario_actualiza',
        'opciones_validacion',
        'ruta_gen_debito',
    ];
}
