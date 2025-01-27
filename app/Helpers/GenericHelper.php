<?php

namespace App\Helpers;

use Carbon\Carbon;
use Modules\Products\Models\Product;

class GenericHelper
{
    protected static $retries = 0;

    public static function generateItemCode()
    {
        do {
            $refno = Self::generateGeneric();
        } while (Self::doesReferenceNumberExists($refno));

        return $refno;
    }

    private static function generateGeneric()
    {
        $date = Carbon::now()->format("dmYHis");

        return $date . sprintf('%04d', rand(1, 9999));
    }

    private static function doesReferenceNumberExists(string $refno)
    {
        $count = 0;
        if(!is_null($refno)){
            $count += Product::where('itemcode', 'like', '%' . $refno)->count();
        }

        Self::$retries += 1;
        return $count > 0;
    }
}