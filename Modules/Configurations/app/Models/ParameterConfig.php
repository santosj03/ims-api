<?php

namespace Modules\Configurations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParameterConfig extends Model
{
    use SoftDeletes;
    
    protected $table = 'parameter_configs';

    protected $fillable = [
        'category',
        'code',
        'description',
        'data_type',
        'value'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\ParameterConfigFactory::new();
    }
}
