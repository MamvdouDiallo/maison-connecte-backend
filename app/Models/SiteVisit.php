<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = ['visitor_id', 'path'];
}
