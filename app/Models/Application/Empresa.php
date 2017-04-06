<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Empresa extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['razao','fantasia','cpf_cnpj','tipo_pessoa','responsavel','email','status'];

}
