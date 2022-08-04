<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json([
            'data' => Comment::all() ?? [],
        ], 200);
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'data' => $comment,
        ], 200);
    }

    public function create(Request $request, string $postId)
    {
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $data = $request->only(['content']);

        $data['id'] = Str::uuid();
        $data['user_id'] = Auth::user()->getAuthIdentifier();
        $data['post_id'] = $postId;

        $comment = Comment::create($data);

        return response()->json([
            'data' => $comment,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $data = $request->only(['content']);

        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        $comment->update($data);

        return response()->json([
            'data' => $comment
        ], 200);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted',
        ]);
    }

    public function post($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        $post = $comment->post;

        return response()->json([
            'data' => $post ?? [],
        ], 200);
    }

    public function user($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'data' => $comment->user,
        ], 200);
    }
}
