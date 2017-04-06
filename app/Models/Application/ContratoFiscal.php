<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class ContratoFiscal extends Model
{
    protected $table = 'contratos_fiscais';

    protected $fillable = ['contrato_id','user_id'];
}
