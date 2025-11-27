<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PackProduct extends Model
{
        use HasFactory; // <- Important !

    protected $table = 'pack_products';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
}
