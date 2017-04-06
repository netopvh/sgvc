<?php
namespace App\Enum;

use Greg0ire\Enum\AbstractEnum;

class TipoPessoa extends AbstractEnum
{

    const PF = "Pessoa Física";
    const PJ = "Pessoa Jurídica";

    public static function getValue($str)
    {

        foreach(self::getConstants() as $key => $value){
            if($key == $str){
                return $value;
            }
        }
        return false;

    }
}