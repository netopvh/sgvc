<?php
namespace App\Exceptions\Access;

class GeneralException extends \Exception
{

    public function setMessage($message)
    {
        return $this->message = $message;
    }

}