<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Service extends Model


{
        use HasFactory; // <- Important !

    protected $fillable = [
    'name',
    'description',
    'price',
    'available_online',
];


     public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
