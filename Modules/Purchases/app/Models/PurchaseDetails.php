<?php

namespace Modules\Purchases\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseDetails extends Model
{
    use HasFactory;

    protected $table = 'purchase_details';
    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_sku',
        'product_name',
        'qty',
        'price',
        'remarks',
        'is_received',
        'qty_received'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function product()
    {
        return $this->hasOne(ProductRepository::class, 'id', 'product_id');
    }
}
