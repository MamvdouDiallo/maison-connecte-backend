<?php

namespace App\Http\Controllers;

use App\Models\Finition;
use App\Http\Resources\FinitionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinitionController extends Controller
{
    // GET /api/public/finitions
    public function index()
    {
        $finitions = Finition::orderBy('ordre')->get();
        return FinitionResource::collection($finitions);
    }

    // GET /api/public/finitions/{id}
    public function show(Finition $finition)
    {
        return new FinitionResource($finition);
    }

    // POST /api/admin/finitions
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'            => 'required|array',
            'titre.fr'         => 'required|string',
            'titre.en'         => 'nullable|string',
            'description'      => 'required|array',
            'description.fr'   => 'required|string',
            'description.en'   => 'nullable|string',
            'photo'            => 'required|image|max:4096',
            'galerie.*'        => 'nullable|image|max:4096',
            'categorie'        => 'required|in:peinture,carrelage,menuiserie,design,plafonds',
            'ordre'            => 'integer',
        ]);

        $photoPath = $request->file('photo')->store('finitions', 'public');

        $galeriePaths = [];
        if ($request->hasFile('galerie')) {
            foreach ($request->file('galerie') as $img) {
                $galeriePaths[] = $img->store('finitions', 'public');
            }
        }

        $finition = Finition::create([
            'titre'       => $validated['titre'],
            'description' => $validated['description'],
            'photo'       => $photoPath,
            'galerie'     => $galeriePaths ?: null,
            'categorie'   => $validated['categorie'],
            'ordre'       => $validated['ordre'] ?? 0,
        ]);

        return new FinitionResource($finition);
    }

    // PUT /api/admin/finitions/{id}
    public function update(Request $request, Finition $finition)
    {
        $validated = $request->validate([
            'titre'            => 'sometimes|array',
            'titre.fr'         => 'sometimes|string',
            'titre.en'         => 'nullable|string',
            'description'      => 'sometimes|array',
            'description.fr'   => 'sometimes|string',
            'description.en'   => 'nullable|string',
            'photo'            => 'nullable|image|max:4096',
            'galerie.*'        => 'nullable|image|max:4096',
            'categorie'        => 'sometimes|in:peinture,carrelage,menuiserie,design,plafonds',
            'ordre'            => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($finition->photo);
            $validated['photo'] = $request->file('photo')->store('finitions', 'public');
        }

        if ($request->hasFile('galerie')) {
            foreach ($finition->galerie ?? [] as $oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            $galeriePaths = [];
            foreach ($request->file('galerie') as $img) {
                $galeriePaths[] = $img->store('finitions', 'public');
            }
            $validated['galerie'] = $galeriePaths;
        }

        $finition->update($validated);

        return new FinitionResource($finition);
    }

    // DELETE /api/admin/finitions/{id}
    public function destroy(Finition $finition)
    {
        Storage::disk('public')->delete($finition->photo);

        foreach ($finition->galerie ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $finition->delete();

        return response()->json(['success' => true]);
    }
}
