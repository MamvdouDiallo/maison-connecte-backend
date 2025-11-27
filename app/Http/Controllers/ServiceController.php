<?php

namespace App\Http\Controllers;


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
            'available_online' => 'boolean'
        ]);

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
            'available_online' => 'boolean'
        ]);

        $service->update($data);

        return $service;
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return ['message' => 'Deleted'];
    }
}
