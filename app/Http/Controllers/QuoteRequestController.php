<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of the resource (GET /quote-requests).
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => QuoteRequest::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage (POST /quote-request).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1
            'serviceType' => 'required|string',
            'residenceType' => 'required|string',
            'estimatedDate' => 'required|date',

            // Step 2 checkboxes
            'securityElectronic' => 'required|boolean',
            'smartHome' => 'required|boolean',
            'solarInstallation' => 'required|boolean',
            'premiumFinishes' => 'required|boolean',
            'completeProject' => 'required|boolean',

            // Step 2 installation details
            'propertyType' => 'required|string',
            'address' => 'required|string',
            'surface' => 'required|string',
            'floors' => 'required|string',
            'currentState' => 'required|string',
            'projectNeeds' => 'nullable|string',
            'budget' => 'required|string',
            'interventionDate' => 'nullable|date',

            // Step 3
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',

            // Files
            // 'files.*' => 'file|max:4096'
        ]);

        // Store files
        // $uploadedFiles = [];
        // if ($request->hasFile('files')) {
        //     foreach ($request->file('files') as $file) {
        //         $uploadedFiles[] = $file->store('quote_requests', 'public');
        //     }
        // }

        // Create in database
        $quote = QuoteRequest::create([
            // Step 1
            'service_type' => $validated['serviceType'],
            'residence_type' => $validated['residenceType'],
            'estimated_date' => $validated['estimatedDate'],

            // Step 2 checkboxes
            'security_electronic' => $validated['securityElectronic'],
            'smart_home' => $validated['smartHome'],
            'solar_installation' => $validated['solarInstallation'],
            'premium_finishes' => $validated['premiumFinishes'],
            'complete_project' => $validated['completeProject'],

            // Step 2 installation details
            'property_type' => $validated['propertyType'],
            'address' => $validated['address'],
            'surface' => $validated['surface'],
            'floors' => $validated['floors'],
            'current_state' => $validated['currentState'],
            'project_needs' => $validated['projectNeeds'] ?? null,
            'budget' => $validated['budget'],
            'intervention_date' => $validated['interventionDate'] ?? null,

            // Step 3
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],

            // Files
            // 'files' => $uploadedFiles
        ]);

        Mail::to(env('ADMIN_EMAIL'))->send(new QuoteRequestNotification($quote));


        return response()->json([
            'success' => true,
            'message' => 'Demande de devis envoyée avec succès.',
            'data' => $quote
        ], 201);
    }

    /**
     * Display a single resource (GET /quote-requests/{id})
     */
    public function show($id)
    {
        $quote = QuoteRequest::find($id);

        if (!$quote) {
            return response()->json([
                'success' => false,
                'message' => 'Quote request not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $quote
        ]);
    }

    /**
     * Update the specified resource (PUT /quote-requests/{id})
     */
    public function update(Request $request, $id)
    {
        $quote = QuoteRequest::find($id);

        if (!$quote) {
            return response()->json([
                'success' => false,
                'message' => 'Quote request not found.'
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,done'
        ]);

        $quote->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Quote updated successfully.',
            'data' => $quote
        ]);
    }

    /**
     * Remove the specified resource (DELETE /quote-requests/{id})
     */
    public function destroy($id)
    {
        $quote = QuoteRequest::find($id);

        if (!$quote) {
            return response()->json([
                'success' => false,
                'message' => 'Quote request not found.'
            ], 404);
        }

        $quote->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quote deleted successfully.'
        ]);
    }
}
