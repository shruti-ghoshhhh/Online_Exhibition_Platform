<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Artwork $artwork)
    {
        return response()->json($artwork->comments()->with('user')->get());
    }

    public function store(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'body' => 'required|string'
        ]);

        $comment = $artwork->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body']
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $comment->delete();
        return response()->json(null, 204);
    }
}
