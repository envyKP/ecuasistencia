<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaCabeceraCargaCorpBitacora extends Model
{
    use HasFactory;
    protected $table = "ea_cabecera_carga_corp_bita";
    public $timestamps = false;

    protected $fillable = [
        'cod_carga',
        'proceso',
        'cliente',
        'producto',
        'desc_producto',
        'fec_carga',
        'archivo',
        'total_registros_archivo',
        'total_registros_sin_infor',
        'total_registros_disponibles_gestion',
        'total_registros_aceptan',
        'total_otros_call_types',
        'usuario_registra',
        'fec_registro',
        'estado',
        'visible'
    ];
}
