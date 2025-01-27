<?php

namespace Modules\Orders\Models;

use Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Products\Repositories\ProductItemRepository;
use Modules\Products\Repositories\ProductRepository;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'order_details';
    protected $fillable = [
        'product_id',
        'product_item_id',
        'order_id',
        'price',
        'rts_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->hasOne(ProductRepository::class, 'id', 'product_id');
    }

    public function product_item()
    {
        return $this->hasOne(ProductItemRepository::class, 'id', 'product_item_id');
    }
}
