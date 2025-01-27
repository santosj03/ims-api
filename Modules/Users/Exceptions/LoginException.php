<?php

namespace Modules\Users\Exceptions;

use App\Base\BaseException;
use Modules\Configurations\Services\ConfigurationService;


class LoginException extends BaseException
{
    protected $code;
    protected $error;

    public function __construct($code)
    {
        $this->code = $code;
        $this->error = ConfigurationService::mapping($this->code);
    }

    public function message()
    {
        return $this->error['message'];
    }
    /**
     * @inheritDoc
     */
    public function statusCode()
    {
        return $this->error['status'];
    }

    /**
     * @inheritDoc
     */
    public function errorCode()
    {
        return $this->error['code'];
    }
}