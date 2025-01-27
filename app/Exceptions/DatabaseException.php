<?php

namespace App\Exceptions;

use App\Base\BaseException;


class DatabaseException extends BaseException
{
    public function message()
    {
        return "Sorry! This service currently unavailable. Please try again later. <DB-EXCP>";
    }

    public function statusCode()
    {
        return 400;
    }

    public function errorCode()
    {
        return "db_exception";
    }
}