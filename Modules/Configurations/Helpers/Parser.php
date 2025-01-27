<?php

namespace Modules\Configurations\Helpers;

use Modules\Configurations\Domain\ConfigDomain;

class Parser
{
    private static $value;

    public static function parse($dataType, $value)
    {
        self::$value = $value;

        switch ($dataType) {
            case ConfigDomain::DATA_TYPE['boolean']:
                return self::toBoolean();
            case ConfigDomain::DATA_TYPE['int']:
                return self::toInt();
            default:
                return self::$value;
        }
    }

    private static function toBoolean()
    {
        return filter_var(self::$value, FILTER_VALIDATE_BOOLEAN);
    }

    private static function toInt()
    {
        return intval(self::$value);
    }
}