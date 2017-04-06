<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ContratoAditivo extends Model
{
    protected $table = 'contrato_aditivos';

    protected $fillable = [
        'contrato_id','ano','aditivos','total','mensal','inicio','encerramento','objeto','arquivo'
    ];

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
