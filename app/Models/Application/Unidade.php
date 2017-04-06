<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Unidade extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = ['name','casa_id'];

    public function casa()
    {
       return $this->belongsTo('App\Models\Application\Casa');
    }

}
