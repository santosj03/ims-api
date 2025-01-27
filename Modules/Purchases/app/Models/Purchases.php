<?php

namespace Modules\Purchases\Models;

use Modules\Products\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Modules\Purchases\Models\PurchaseDetails;
use Modules\Configurations\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchases extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'po_no',
        'description',
        'supplier_id',
        'amount',
        'ship_via',
        'target_delivery',
        'payment_type_id',
        'payment_status',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetails::class, 'purchase_id', 'id');
    }

    public function payment_type()
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}
