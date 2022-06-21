<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EaCliente extends Model
{
    use HasFactory;
    protected $table= 'ea_clientes';
    public $timestamps = false;
}
