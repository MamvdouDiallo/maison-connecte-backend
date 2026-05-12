<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $clients]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:clients,slug',
            'logo'              => 'nullable|string',
            'website'           => 'nullable|url',
            'industry'          => 'nullable|string',
            'description'       => 'nullable|string',
            'contact_person'    => 'nullable|string',
            'email'             => 'nullable|email',
            'phone'             => 'nullable|string',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string',
            'country'           => 'nullable|string',
            'partnership_start' => 'nullable|date',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
            'order'             => 'integer',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return response()->json(Client::create($data), 201);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'              => 'sometimes|string|max:255',
            'slug'              => 'nullable|string|unique:clients,slug,' . $client->id,
            'logo'              => 'nullable|string',
            'website'           => 'nullable|url',
            'industry'          => 'nullable|string',
            'description'       => 'nullable|string',
            'contact_person'    => 'nullable|string',
            'email'             => 'nullable|email',
            'phone'             => 'nullable|string',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string',
            'country'           => 'nullable|string',
            'partnership_start' => 'nullable|date',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
            'order'             => 'integer',
        ]);

        $client->update($data);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, 204);
    }
}
