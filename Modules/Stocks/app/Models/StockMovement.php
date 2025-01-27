<?php

namespace Modules\Stocks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movement';
    protected $fillable = [
        'type',
        'reference_no',
        'product_id',
        'product_item_id',
        'serial',
        'beg_bal',
        'qty',
        'end_bal',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
    ];
}