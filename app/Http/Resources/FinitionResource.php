<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FinitionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'titre'       => $this->titre,
            'description' => $this->description,
            'photo'       => $this->photo ? Storage::disk('public')->url($this->photo) : null,
            'galerie'     => collect($this->galerie ?? [])->map(
                fn($path) => Storage::disk('public')->url($path)
            )->values(),
            'categorie'   => $this->categorie,
            'ordre'       => $this->ordre,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
