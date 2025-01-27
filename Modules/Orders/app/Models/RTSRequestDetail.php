<?php

namespace Modules\Orders\Models;

use Modules\Orders\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RTSRequestDetail extends Model
{
    use HasFactory;

    protected $table = 'rts_request_details';
    protected $fillable = [
        'rts_request_id',
        'order_detail_id'
    ];

    public function order_details()
    {
        return $this->hasOne(OrderDetail::class, 'id', 'order_detail_id');
    }
}
