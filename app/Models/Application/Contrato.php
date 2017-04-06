<?php

namespace App\Models\Application;

use App\Models\Application\Traits\ContratoTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Contrato extends Model implements Transformable
{
    use ContratoTrait, TransformableTrait, SoftDeletes;

    protected $fillable = ['tipo', 'numero', 'ano', 'modalidade', 'tipo_servico', 'casa_id', 'unidade_id',
        'aditivado', 'ambito', 'total', 'mensal', 'inicio', 'encerramento', 'objeto','arquivo', 'status','orig_ano',
    'orig_inicio','orig_encerramento','orig_total','orig_mensal','orig_objeto'];



}
