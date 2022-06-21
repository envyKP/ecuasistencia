<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaSegurViaje extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrvDatClientes';
    protected $table ='SEGURVIAJE_CARG';
    public $timestamps = false;

}
