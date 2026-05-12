<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_type_id', 'title', 'description', 'location',
        'year', 'thumbnail', 'client', 'duration', 'is_active', 'order',
    ];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function tags()
    {
        return $this->hasMany(ProjectTag::class);
    }

    public function services()
    {
        return $this->hasMany(ProjectService::class);
    }
}
