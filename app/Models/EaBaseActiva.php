<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EaBaseActiva extends Model
{
    use HasFactory;

    protected $table ='ea_base_activa';
    public $timestamps = false;

    protected $fillable = [
        'id_sec',
        'cuenta',
        'tarjeta',
    ];

}
