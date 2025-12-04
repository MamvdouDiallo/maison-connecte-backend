<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category', 'subCategory', 'images')->get();
    }

    public function show(Product $product)
    {
        return $product->load('category', 'subCategory', 'images');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
            'link' => 'nullable|string',
            'highlights' => 'nullable|array',
            'specs' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
            }
        }

        return $product->load('images');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
            'link' => 'nullable|string',
            'highlights' => 'nullable|array',
            'specs' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }

            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
            }
        }

        return $product->load('images');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function getByCategory($categoryId)
{
    return Product::with('category', 'subCategory', 'images')
        ->where('category_id', $categoryId)
        ->get();
}

public function getBySubCategory($subCategoryId)
{
    return Product::with('category', 'subCategory', 'images')
        ->where('subcategory_id', $subCategoryId)
        ->get();
}


}
