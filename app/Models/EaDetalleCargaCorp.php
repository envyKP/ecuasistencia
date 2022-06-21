<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaDetalleCargaCorp extends Model
{

    use HasFactory;

    protected $table = 'ea_detalle_carga_corp';
    public $timestamps = false;

    protected $fillable = [
        'cod_carga',
        'cliente',
        'ordinal',
        'nombre_completo',
        'cedula_id',
        'genero',
        'email',
        'telefono1',
        'telefono2',
        'telefono3',
        'telefono4',
        'telefono5',
        'telefono6',
        'telefono7',
        'ciudad',
        'tipo_de_tarjeta',
        'campo_1',
        'campo_2',
        'campo_3',
        'campo_4',
        'campo_5',
        'campo_6',
        'campo_7',
        'estado',
        'disponible_gestion',
        'fec_carga',
    ];

}
