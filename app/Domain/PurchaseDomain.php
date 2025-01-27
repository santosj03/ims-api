<?php

namespace App\Domain;

class PurchaseDomain
{
    const PURCHASE_RELATIONSHIPS = [
        'supplier',
        'payment_type',
        'purchase_details.product',
    ];
}