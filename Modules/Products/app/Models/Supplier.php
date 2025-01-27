<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'code',
        'name',
        'address',
        'email',
        'mobile',
        'bank_name',
        'bank_number',
        'courier',
        'is_active',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
