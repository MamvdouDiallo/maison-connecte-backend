<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finition extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'photo',
        'galerie',
        'categorie',
        'ordre',
    ];

    protected $casts = [
        'titre'       => 'array',
        'description' => 'array',
        'galerie'     => 'array',
    ];
}
