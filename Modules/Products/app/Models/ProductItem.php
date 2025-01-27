<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductItem extends Model
{
    use HasFactory;

    protected $table = 'product_items';
    protected $fillable = [
        'product_id',
        'branch_id',
        'serial',
        'is_sold',
        'date_sold',
    ];

    public function product()
    {
        return $this->belongsTo(ProductRepository::class, 'product_id', 'id');
    }
}
