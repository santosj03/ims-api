<?php

namespace Modules\Stocks\Models;

use Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Stocks\Models\StockReceivingDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockReceiving extends Model
{
    use HasFactory;

    protected $table = 'stock_receiving';
    protected $fillable = [
        'received_id',
        'received_type',
        'total_received_item',
        'total_pending_item',
        'received_by',
        'remarks',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'received_by');
    }

    public function received()
    {
        return $this->morphTo();
    }

    public function receiving_details()
    {
        return $this->hasMany(StockReceivingDetails::class, 'stock_receiving_id', 'id');
    }
}