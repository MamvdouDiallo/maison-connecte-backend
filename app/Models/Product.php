<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'pack_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
