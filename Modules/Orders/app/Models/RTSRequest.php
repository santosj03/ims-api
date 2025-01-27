<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Models\RTSRequestDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RTSRequest extends Model
{
    use HasFactory;

    protected $table = 'rts_requests';
    protected $fillable = [
        'order_id',
        'is_per_item',
        'description',
        'status',
        'encoded_by',
        'validated_by'
    ];

    public function rts_request_details()
    {
        return $this->hasMany(RTSRequestDetail::class, 'rts_request_id', 'id');
    }
}
