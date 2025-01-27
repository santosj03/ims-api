<?php

namespace App\Domain;

class OrderDomain
{
    const RTS_RELATIONSHIPS = [
        'rts_request_details.order_details.order',
        'rts_request_details.order_details.product',
        'rts_request_details.order_details.product_item'
    ];
}