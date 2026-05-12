<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $fillable = ['slug', 'name', 'description', 'icon', 'color', 'is_active', 'order'];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
