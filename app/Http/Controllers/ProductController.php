<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category', 'subCategory')->paginate(20);
    }

    public function show(Product $product)
    {
        return $product->load('category', 'subCategory', 'packs');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'title'         => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'image'         => 'nullable',
            'link'          => 'nullable',
            'highlights'    => 'nullable|array',
            'specs'         => 'nullable|array',
        ]);

        return Product::create($data);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'title'         => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'image'         => 'nullable',
            'link'          => 'nullable',
            'highlights'    => 'nullable|array',
            'specs'         => 'nullable|array',
        ]);

        $product->update($data);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
