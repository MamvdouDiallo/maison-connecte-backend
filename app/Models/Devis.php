<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected $casts = [
        'security_electronic' => 'boolean',
        'smart_home'          => 'boolean',
        'solar_installation'  => 'boolean',
        'premium_finishes'    => 'boolean',
        'complete_project'    => 'boolean',
        'intervention_date'   => 'date',
    ];
}
