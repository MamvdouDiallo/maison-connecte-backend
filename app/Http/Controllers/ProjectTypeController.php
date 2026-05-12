<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $types = ProjectType::where('is_active', true)
            ->orderBy('order')
            ->get();
        return response()->json($types);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|array',
            'name.fr'     => 'required|string',
            'name.en'     => 'nullable|string',
            'description' => 'nullable|array',
            'slug'        => 'nullable|string|unique:project_types,slug',
            'icon'        => 'nullable|string',
            'color'       => 'nullable|string',
            'is_active'   => 'boolean',
            'order'       => 'integer',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']['fr']);

        return response()->json(ProjectType::create($data), 201);
    }

    public function show(ProjectType $projectType)
    {
        return response()->json($projectType);
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $data = $request->validate([
            'name'        => 'sometimes|array',
            'name.fr'     => 'sometimes|string',
            'name.en'     => 'nullable|string',
            'description' => 'nullable|array',
            'slug'        => 'nullable|string|unique:project_types,slug,' . $projectType->id,
            'icon'        => 'nullable|string',
            'color'       => 'nullable|string',
            'is_active'   => 'boolean',
            'order'       => 'integer',
        ]);

        $projectType->update($data);
        return response()->json($projectType);
    }

    public function destroy(ProjectType $projectType)
    {
        $projectType->delete();
        return response()->json(null, 204);
    }
}
