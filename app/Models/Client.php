<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'website', 'industry', 'description',
        'contact_person', 'email', 'phone', 'address', 'city', 'country',
        'partnership_start', 'is_featured', 'is_active', 'order',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'is_featured'      => 'boolean',
        'partnership_start' => 'date',
    ];
}
