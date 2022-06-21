<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaMigracionBaseActiva extends Model
{
    use HasFactory;
    protected $table = "ea_migracion_base_activa";
    public $timestamps = false;

}
