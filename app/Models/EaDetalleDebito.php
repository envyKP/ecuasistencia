<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaDetalleDebito extends Model
{
    use HasFactory;

    protected $table = 'ea_detalle_debito';
    public $timestamps = false;

    protected $fillable = [
        'id_sec',
        'id_carga',
        'secuencia',
        'fecha_actualizacion',
        'fecha_registro',
        'producto',
        'cliente',
        'estado',
        'detalle',
        'fecha_generacion',
        'subproducto_id',
        'valor_debitado'
       
    ];
}
