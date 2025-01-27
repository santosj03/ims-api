<?php

namespace App\Domain;

class GenericDomain
{
    const CACHE_TYPE = [
        'CONTENT_MAPPING' => 'content_mapping',
        'PARAMETER_CONF' => 'parameter_config',
        'CATEGORIES' => 'product_categories',
        'SUPPLIERS' => 'product_suppliers'
    ];

    const ERR_LOGIN_CRED = "err_login_cred";
    const ERR_LOGIN_TOKEN = "err_login_token";
}