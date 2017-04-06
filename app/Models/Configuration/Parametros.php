<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Parametros extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
