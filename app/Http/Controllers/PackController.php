<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    public function index()
    {
        return Pack::with('products')->get();
    }

    public function show(Pack $pack)
    {
        return $pack->load('products');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
            'price'       => 'required|numeric',
            'installation_included' => 'boolean',
            'products'    => 'array',
        ]);

        $pack = Pack::create($data);

        if (!empty($data['products'])) {
            $pack->products()->sync($data['products']);
        }

        return $pack->load('products');
    }

    public function update(Request $request, Pack $pack)
    {
        $data = $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
            'price'       => 'required|numeric',
            'installation_included' => 'boolean',
            'products'    => 'array',
        ]);

        $pack->update($data);

        if (!empty($data['products'])) {
            $pack->products()->sync($data['products']);
        }

        return $pack->load('products');
    }

    public function destroy(Pack $pack)
    {
        $pack->delete();
        return ['message' => 'Deleted'];
    }
}
