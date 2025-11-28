<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'nullable|numeric',
            'available_online' => 'boolean',
            'image' => 'nullable|image|max:2048' // 2MB max
        ]);

        // 🎯 Upload si présent
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('service_images', 'public');
            // Ex: service_images/ab34563.png
        }

        return Service::create($data);
    }

    public function show(Service $service)
    {
        return $service->load('quotes');
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'nullable|numeric',
            'available_online' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);

        // 🎯 Upload d'une nouvelle image
        if ($request->hasFile('image')) {

            // ➕ Delete ancienne image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $data['image'] = $request->file('image')->store('service_images', 'public');
        }

        $service->update($data);

        return $service;
    }

    public function destroy(Service $service)
    {
        // Delete image si existante
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return ['message' => 'Deleted'];
    }
}
