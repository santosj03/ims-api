<?php

namespace Modules\Configurations\Domain;

class ConfigDomain
{
    const DATA_TYPE = [
        'int' => 'INT',
        'string' => 'STRING',
        'boolean' => 'BOOLEAN',
        'time' => 'TIME'
    ];

    const SESSION_TIMEOUT = 'sec_session_timeout';
    const ACCOUNT_INACTIVITY = 'sec_account_inactivity_days';
}