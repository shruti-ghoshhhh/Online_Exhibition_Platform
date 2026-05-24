<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'likeable_id' => 'required|integer',
            'likeable_type' => 'required|string|in:artwork,exhibition',
        ]);
        
        $typeMap = [
            'artwork' => 'App\Models\Artwork',
            'exhibition' => 'App\Models\Exhibition',
        ];

        $like = Like::firstOrCreate([
            'user_id' => $request->user()->id,
            'likeable_id' => $validated['likeable_id'],
            'likeable_type' => $typeMap[$validated['likeable_type']],
        ]);

        return response()->json($like, 201);
    }

    public function destroy(Request $request, $id)
    {
        Like::where('user_id', $request->user()->id)->where('id', $id)->delete();
        return response()->json(null, 204);
    }
}
