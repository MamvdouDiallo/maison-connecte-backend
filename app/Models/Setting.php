<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'value_json',
        'type',
        'label',
    ];

    protected $casts = [
        'value_json' => 'array',
    ];
}
