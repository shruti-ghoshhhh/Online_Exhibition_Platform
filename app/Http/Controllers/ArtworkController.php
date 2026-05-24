<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index(Exhibition $exhibition)
    {
        return response()->json($exhibition->artworks()->with('user')->get());
    }

    public function store(Request $request, Exhibition $exhibition)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'required|string',
            'artist_name' => 'nullable|string',
            'display_order' => 'integer'
        ]);

        $validated['user_id'] = $request->user()->id;

        $artwork = $exhibition->artworks()->create($validated);
        return response()->json($artwork, 201);
    }

    public function show(Artwork $artwork)
    {
        return response()->json($artwork->load('user', 'exhibition'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'string',
            'artist_name' => 'nullable|string',
            'display_order' => 'integer'
        ]);

        $artwork->update($validated);
        return response()->json($artwork);
    }

    public function destroy(Artwork $artwork)
    {
        $artwork->delete();
        return response()->json(null, 204);
    }
}
