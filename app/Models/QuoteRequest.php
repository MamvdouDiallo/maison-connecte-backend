<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'service_type',
        'residence_type',
        'estimated_date',
        'security_electronic',
        'smart_home',
        'solar_installation',
        'premium_finishes',
        'complete_project',
        'property_type',
        'address',
        'surface',
        'floors',
        'current_state',
        'project_needs',
        'budget',
        'intervention_date',
        'name',
        'phone',
        'email',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
        'estimated_date' => 'date',
        'intervention_date' => 'date',
        'security_electronic' => 'boolean',
        'smart_home' => 'boolean',
        'solar_installation' => 'boolean',
        'premium_finishes' => 'boolean',
        'complete_project' => 'boolean',
    ];
}
