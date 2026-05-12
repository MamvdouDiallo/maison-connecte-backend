<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['projectType', 'images', 'tags', 'services'])
            ->where('is_active', true)
            ->orderBy('order')
            ->orderByDesc('year')
            ->get();

        return response()->json($projects);
    }

    public function show(Project $project)
    {
        return response()->json(
            $project->load(['projectType', 'images', 'tags', 'services'])
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id'  => 'required|exists:project_types,id',
            'title'            => 'required|array',
            'title.fr'         => 'required|string',
            'title.en'         => 'nullable|string',
            'description'      => 'nullable|array',
            'location'         => 'nullable|string',
            'year'             => 'nullable|string|max:4',
            'thumbnail'        => 'nullable|string',
            'client'           => 'nullable|string',
            'duration'         => 'nullable|string',
            'is_active'        => 'boolean',
            'order'            => 'integer',
            'images'           => 'nullable|array',
            'images.*.image_path' => 'required|string',
            'images.*.order'   => 'integer',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string',
            'services'         => 'nullable|array',
            'services.*'       => 'in:security,automation,solar,finishing',
        ]);

        $project = Project::create($data);

        if (!empty($data['images'])) {
            $project->images()->createMany($data['images']);
        }

        if (!empty($data['tags'])) {
            $project->tags()->createMany(
                array_map(fn($t) => ['tag' => $t], $data['tags'])
            );
        }

        if (!empty($data['services'])) {
            $project->services()->createMany(
                array_map(fn($s) => ['service' => $s], $data['services'])
            );
        }

        return response()->json(
            $project->load(['projectType', 'images', 'tags', 'services']),
            201
        );
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'project_type_id'     => 'sometimes|exists:project_types,id',
            'title'               => 'sometimes|array',
            'title.fr'            => 'sometimes|string',
            'title.en'            => 'nullable|string',
            'description'         => 'nullable|array',
            'location'            => 'nullable|string',
            'year'                => 'nullable|string|max:4',
            'thumbnail'           => 'nullable|string',
            'client'              => 'nullable|string',
            'duration'            => 'nullable|string',
            'is_active'           => 'boolean',
            'order'               => 'integer',
            'images'              => 'nullable|array',
            'images.*.image_path' => 'required|string',
            'images.*.order'      => 'integer',
            'tags'                => 'nullable|array',
            'tags.*'              => 'string',
            'services'            => 'nullable|array',
            'services.*'          => 'in:security,automation,solar,finishing',
        ]);

        $project->update($data);

        if (array_key_exists('images', $data)) {
            $project->images()->delete();
            if (!empty($data['images'])) {
                $project->images()->createMany($data['images']);
            }
        }

        if (array_key_exists('tags', $data)) {
            $project->tags()->delete();
            if (!empty($data['tags'])) {
                $project->tags()->createMany(
                    array_map(fn($t) => ['tag' => $t], $data['tags'])
                );
            }
        }

        if (array_key_exists('services', $data)) {
            $project->services()->delete();
            if (!empty($data['services'])) {
                $project->services()->createMany(
                    array_map(fn($s) => ['service' => $s], $data['services'])
                );
            }
        }

        return response()->json(
            $project->load(['projectType', 'images', 'tags', 'services'])
        );
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}
