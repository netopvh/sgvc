<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class ContratoEmpresa extends Model
{
    protected $table = 'contrato_empresas';

    protected $fillable = ['contrato_id','empresa_id'];
}
