<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        return SubCategory::with('category')->get();
    }

    public function show(SubCategory $subCategory)
    {
        return $subCategory->load('category', 'products');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required',
            'slug'        => 'required|unique:sub_categories',
            'description' => 'nullable',
        ]);

        return SubCategory::create($data);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required',
            'slug'        => 'required|unique:sub_categories,slug,' . $subCategory->id,
            'description' => 'nullable',
        ]);

        $subCategory->update($data);

        return $subCategory;
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Méthode pour récupérer les sous-catégories d'une catégorie
    public function fromCategory($categoryId)
    {
        return SubCategory::where('category_id', $categoryId)->get();
    }
}
