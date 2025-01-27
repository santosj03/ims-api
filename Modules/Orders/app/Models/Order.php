<?php

namespace Modules\Orders\Models;

use Modules\Users\Models\User;
use Modules\Orders\Models\Customer;
use Modules\Products\Models\Branch;
use Modules\Orders\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Modules\Configurations\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'encoder_id',
        'branch_id',
        'payment_type_id',
        'payment_status',
        'item_count',
        'downpayment',
        'ship_cost',
        'other_cost',
        'amount',
        'discount',
        'status',
        'is_with_rts',
        'expires_at',
        'confirmed_at',
        'paid_at',
        'delivered_at'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function encoder()
    {
        return $this->hasOne(User::class, 'id', 'encoder_id');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function payment_type()
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
