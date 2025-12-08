<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    // public function show(BlogPost $post)
    // {
    //     return $post->load('category');
    // }

    public function show($id)
{
    $blog = Blog::with('category')->find($id);

    if (!$blog) {
        return response()->json(['message' => 'Article non trouvé'], 404);
    }

    return response()->json($blog);
}


    
}
