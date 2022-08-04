<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('auth.admin');
    }

    public function index()
    {
        return response()->json([
            'data' => Post::all() ?? [],
        ], 200);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'data' => $post,
        ], 200);
    }

    public function create(Request $request)
    {
        $data = $this->validatePost($request);

        $data['id'] = Str::uuid();
        $data['user_id'] = Auth::user()->getAuthIdentifier();

        $post = Post::create($data);

        return response()->json([
            'data' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validatePost($request);

        $post = Post::find($id);
        $post->update($data);

        return response()->json([
            'data' => $post
        ], 201);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted',
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validatePost(Request $request): array
    {
        $request->validate([
            'title' => ['required',
                'string',
                'max:255',
            ],
            'content' => ['required'],
        ]);

        $data = $request->only(['title', 'content']);

        $data['slug'] = Str::slug($data['title']);

        if (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'] . '-' . rand(1, 100);
        }

        return $data;
    }
}
