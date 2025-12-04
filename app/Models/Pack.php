<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pack extends Model
{
        use HasFactory; // <- Important !

     public function products()
    {
        return $this->belongsToMany(Product::class, 'pack_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    
}
