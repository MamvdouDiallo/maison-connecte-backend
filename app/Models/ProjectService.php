<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    protected $fillable = ['project_id', 'service'];

    const SERVICES = ['security', 'automation', 'solar', 'finishing'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
