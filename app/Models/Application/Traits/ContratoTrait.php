<?php

namespace App\Models\Application\Traits;

use App\Models\Application\Casa;
use App\Models\Application\ContratoAditivo;
use App\Models\Application\Unidade;
use App\Models\Access\User;
use App\Models\Application\Empresa;
use Carbon\Carbon;

trait ContratoTrait
{
    /**
     * @return mixed
     */
    public function casa()
    {
        return $this->belongsTo(Casa::class);
    }

    /**
     * @return mixed
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * @return mixed
     */
    public function gestores()
    {
        return $this->belongsToMany(User::class,'contrato_gestores','contrato_id','user_id');
    }

    /**
     * @return mixed
     */
    public function fiscais()
    {
        return $this->belongsToMany(User::class,'contrato_fiscais','contrato_id','user_id');
    }

    /**
     * @return mixed
     */
    public function empresas()
    {
        return $this->belongsToMany(Empresa::class,'contrato_empresas','contrato_id','empresa_id');
    }

    public function aditivos()
    {
        return $this->hasMany(ContratoAditivo::class);
    }

    /**
     * @return string
     */
    public function getNumeroAnoAttribute()
    {
        return $this->numero . '/' . $this->ano;
    }

    public function getOrigNumeroAnoAttribute()
    {
        return $this->numero . '/' . $this->orig_ano;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setInicioAttribute($value)
    {
        if (strlen($value) > 0){
            try{
                return $this->attributes['inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }catch(\Exception $e){
                return $this->attributes['inicio'] = date('Y-m-d');
            }
        }
    }

    /**
     * @param $value
     * @return null
     */
    public function getInicioAttribute($value)
    {
        return $this->returnDate($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setEncerramentoAttribute($value)
    {
        if (strlen($value) > 0){
            try{
                return $this->attributes['encerramento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }catch(\Exception $e){
                return $this->attributes['encerramento'] = date('Y-m-d');
            }
        }
    }

    /**
     * @param $value
     * @return null
     */
    public function getEncerramentoAttribute($value)
    {
        return $this->returnDate($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setOrigInicioAttribute($value)
    {
        if (strlen($value) > 0){
            try{
                return $this->attributes['orig_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }catch(\Exception $e){
                return $this->attributes['orig_inicio'] = date('Y-m-d');
            }
        }
    }

    /**
     * @param $value
     * @return null
     */
    public function getOrigInicioAttribute($value)
    {
        return $this->returnDate($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setOrigEncerramentoAttribute($value)
    {
        if (strlen($value) > 0){
            try{
                return $this->attributes['orig_encerramento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }catch(\Exception $e){
                return $this->attributes['orig_encerramento'] = date('Y-m-d');
            }
        }
    }

    /**
     * @param $value
     * @return null
     */
    public function getOrigEncerramentoAttribute($value)
    {
        return $this->returnDate($value);
    }

    /*
     * Função que retorna a data formatada
     *
     * @return date
     */
    private function returnDate($value)
    {
        if (strlen($value) > 0) {
            return (new Carbon($value))->format('d/m/Y');
        } else {
            return null;
        }
    }
}