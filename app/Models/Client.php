<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    protected $appends = ['logo_url'];

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

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }
}
