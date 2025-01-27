<?php

namespace Modules\Stocks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockReceivingDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'stock_receiving_details';
    protected $fillable = [
        'stock_receiving_id',
        'serial'
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
