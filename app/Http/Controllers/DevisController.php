<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Devis;
use App\Mail\DevisAdminNotification;
use App\Mail\DevisClientConfirmation;

class DevisController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|max:50',
            'email'               => 'required|email|max:255',
            'securityElectronic'  => 'boolean',
            'smartHome'           => 'boolean',
            'solarInstallation'   => 'boolean',
            'premiumFinishes'     => 'boolean',
            'completeProject'     => 'boolean',
            'propertyType'        => 'nullable|string',
            'address'             => 'nullable|string',
            'surface'             => 'nullable|string',
            'floors'              => 'nullable|string',
            'currentState'        => 'nullable|string',
            'projectNeeds'        => 'nullable|string',
            'budget'              => 'nullable|string',
            'interventionDate'    => 'nullable|date',
        ]);

        $devis = Devis::create([
            'name'                 => $validated['name'],
            'phone'                => $validated['phone'],
            'email'                => $validated['email'],
            'security_electronic'  => $validated['securityElectronic'] ?? false,
            'smart_home'           => $validated['smartHome'] ?? false,
            'solar_installation'   => $validated['solarInstallation'] ?? false,
            'premium_finishes'     => $validated['premiumFinishes'] ?? false,
            'complete_project'     => $validated['completeProject'] ?? false,
            'property_type'        => $validated['propertyType'] ?? null,
            'address'              => $validated['address'] ?? null,
            'surface'              => $validated['surface'] ?? null,
            'floors'               => $validated['floors'] ?? null,
            'current_state'        => $validated['currentState'] ?? null,
            'project_needs'        => $validated['projectNeeds'] ?? null,
            'budget'               => $validated['budget'] ?? null,
            'intervention_date'    => $validated['interventionDate'] ?? null,
        ]);

        $adminAddress = config('mail.admin_address');
        if ($adminAddress) {
            Mail::to($adminAddress)->send(new DevisAdminNotification($devis));
        }

        Mail::to($devis->email)->send(new DevisClientConfirmation($devis));

        return response()->json(['success' => true], 201);
    }
}
