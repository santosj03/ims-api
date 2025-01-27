<?php

namespace App\Exceptions;

use App\Base\BaseException;


class GenericException extends BaseException
{
    protected $code, $message;
    public function __construct($code = null, $message = null)
    {
        $this->code = $code;
        $this->message = is_null($message) ? "Sorry! This service currently unavailable. Please try again later." : $message;
    }

    public function message()
    {
        if(is_null($this->code)){
            return $this->message;
        }
        return "$this->message <$this->code>";
    }

    public function statusCode()
    {
        return 400;
    }

    public function errorCode()
    {
        return "generic_exception";
    }
}