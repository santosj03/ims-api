<?php

namespace App\Exceptions;

use App\Base\BaseException;


class RTSException extends BaseException
{
    protected $code;
    public function __construct($code = null)
    {
        $this->code = $code;
    }

    public function message()
    {
        if(is_null($this->code)){
            return "Something went wrong!, RTS Module error.";
        }
        return "Error occured, Some of your item were already returned! <$this->code>";
    }

    public function statusCode()
    {
        return 400;
    }

    public function errorCode()
    {
        return "rts_exception";
    }
}