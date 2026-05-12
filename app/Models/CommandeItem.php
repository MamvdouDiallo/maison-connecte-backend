<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandeItem extends Model
{
    use HasFactory;

    protected $fillable = ['commande_id', 'title', 'price', 'quantity', 'line_total'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
