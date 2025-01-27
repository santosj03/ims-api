<?php

namespace Modules\Stocks\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Repositories\ProductItemRepository;

class StockTransferDetails extends Model
{
    use HasFactory;

    protected $table = 'stock_transfer_details';
    protected $fillable = [
        'stock_transfer_id',
        'product_id',
        'product_item_id',
        'qty',
        'is_received'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function product()
    {
        return $this->hasOne(ProductRepository::class, 'id', 'product_id');
    }

    public function product_item()
    {
        return $this->hasOne(ProductItemRepository::class, 'id', 'product_item_id');
    }
}
