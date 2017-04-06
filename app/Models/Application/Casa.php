<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Casa extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];

    public function unidades()
    {
        return $this->hasMany('App\Models\Application\Unidade');
    }

}
