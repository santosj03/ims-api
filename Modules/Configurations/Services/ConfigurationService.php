<?php

namespace Modules\Configurations\Services;

use App\Domain\GenericDomain;
use Illuminate\Support\Facades\Cache;
use Modules\Configurations\Helpers\Parser;
use Modules\Configurations\Models\ContentMapping;
use Modules\Configurations\Models\ParameterConfig;

class ConfigurationService
{
    public static function param($code)
    {
        $config = Cache::rememberForever(GenericDomain::CACHE_TYPE['PARAMETER_CONF'], function(){
            $conf = [];
            foreach(ParameterConfig::get() as $param){
                $conf[$param['code']] = Parser::parse($param['data_type'], $param['value']);
            }
            
            return $conf;
        });

        return $config[$code];
    }

    public static function mapping($code)
    {
        $mappingErrData = Cache::rememberForever(GenericDomain::CACHE_TYPE['CONTENT_MAPPING'], function(){
            $data = [];
            foreach(ContentMapping::get() as $mapping){
                $data[$mapping['code']] = [
                    "code" => $mapping['code'], 
                    "message" => $mapping['error_message'],
                    "status" => $mapping['error_status']
                ];
            }
            
            return $data;
        });

        return $mappingErrData[$code];
    }
}