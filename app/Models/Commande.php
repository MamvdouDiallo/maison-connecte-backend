<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'message', 'total', 'status'];

    const STATUSES = [
        'en_attente'  => 'En attente',
        'confirmee'   => 'Confirmée',
        'en_cours'    => 'En cours',
        'terminee'    => 'Terminée',
        'annulee'     => 'Annulée',
    ];

    public function items()
    {
        return $this->hasMany(CommandeItem::class);
    }
}
