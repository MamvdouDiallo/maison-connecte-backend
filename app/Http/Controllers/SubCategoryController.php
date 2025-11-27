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

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
        ]);

        return SubCategory::create($data);
    }

    public function show(SubCategory $subCategory)
    {
        return $subCategory->load('products');
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id,
        ]);

        $subCategory->update($data);

        return $subCategory;
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
