<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Service extends Model


{
        use HasFactory; // <- Important !




     public function quotes()
    {
        return $this->hasMany(Quote::class);
    }


    protected $fillable = [
    'name', 'description', 'price', 'available_online', 'image'
];

protected $appends = ['image_url'];

public function getImageUrlAttribute()
{
    if (!$this->image) {
        return null;
    }
    return asset('storage/' . $this->image);
}

}
