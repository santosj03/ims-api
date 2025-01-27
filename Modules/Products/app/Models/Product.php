<?php

namespace Modules\Products\Models;

use App\Traits\CreatorUpdaterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, CreatorUpdaterTrait;

    protected $table = 'products';
    protected $fillable = [
        'itemcode',
        'category_id',
        'brand_id',
        'supplier_id',
        'uom_id',
        'created_by',
        'updated_by',
        'sku',
        'name',
        'description',
        'price',
        'is_per_single_unit',
        'psu_inv_deduction',
        'avg_cost_per_item',
        'maintaining_bal',
        'warranty_terms',
        'image_src',
        'is_active',
        'date_expiry',
    ];
}
