<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserStatus extends Model
{
    use HasFactory;
    protected $table = 'user_status';

    protected $fillable = [
        'code',
        'name',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
