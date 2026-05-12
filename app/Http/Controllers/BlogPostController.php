<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        return BlogPost::with('category')
            ->when($request->category_id, fn($q, $id) =>
                $q->where('category_id', $id)
            )
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public function show($id)
    {
        $post = BlogPost::with('category')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Article non trouvé'], 404);
        }

        return response()->json($post);
    }
}
