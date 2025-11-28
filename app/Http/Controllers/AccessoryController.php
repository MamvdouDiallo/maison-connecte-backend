<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    public function index()
    {
        return Accessory::latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required',
            'description' => 'nullable',
            'price'       => 'nullable|numeric',
            'image'       => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('accessories', 'public');
        }

        return Accessory::create($data);
    }

    public function show(Accessory $accessory)
    {
        return $accessory;
    }

    public function update(Request $request, Accessory $accessory)
    {
        $data = $request->validate([
            'title'       => 'required',
            'description' => 'nullable',
            'price'       => 'nullable|numeric',
            'image'       => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($accessory->image) {
                Storage::disk('public')->delete($accessory->image);
            }

            $data['image'] = $request->file('image')
                ->store('accessories', 'public');
        }

        $accessory->update($data);

        return $accessory;
    }

    public function destroy(Accessory $accessory)
    {
        if ($accessory->image) {
            Storage::disk('public')->delete($accessory->image);
        }

        $accessory->delete();

        return ['message' => 'Deleted'];
    }
}
