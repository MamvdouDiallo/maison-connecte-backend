<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = ['project_id', 'image_path', 'order'];

    // Le frontend attend "url" — on expose image_path sous ce nom
    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return $this->image_path ?? '';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
