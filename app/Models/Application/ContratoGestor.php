<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;

class ContratoGestor extends Model
{
    protected $table = 'contrato_gestores';

    protected $fillable = ['contrato_id','usuario_id'];
}
