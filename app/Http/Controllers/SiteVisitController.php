<?php

namespace App\Http\Controllers;

use App\Models\SiteVisit;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    /**
     * Enregistre une visite unique par visiteur et par jour.
     * Le dédoublonnage se fait ici côté serveur (pas seulement côté client)
     * pour rester fiable même si le frontend est rejoué ou modifié.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'visitor_id' => ['required', 'string', 'max:64'],
            'path'       => ['nullable', 'string', 'max:255'],
        ]);

        $alreadyVisitedToday = SiteVisit::where('visitor_id', $data['visitor_id'])
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (! $alreadyVisitedToday) {
            SiteVisit::create($data);
        }

        return response()->json(['tracked' => ! $alreadyVisitedToday]);
    }
}
