<?php

namespace Modules\Stocks\Models;

use Modules\Products\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Modules\Stocks\Models\StockTransferDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table = 'stock_transfer';
    protected $fillable = [
        'from_branch_id',
        'to_branch_id',
        'total_item',
        'description',
        'status',
        'prepared_by'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function stock_transfer_details()
    {
        return $this->hasMany(StockTransferDetails::class, 'stock_transfer_id', 'id');
    }
}
