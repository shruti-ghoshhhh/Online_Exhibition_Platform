<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index()
    {
        return response()->json(Exhibition::with('user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'category' => 'nullable|string',
            'status' => 'in:draft,active,ended',
            'is_featured' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exhibition = $request->user()->exhibitions()->create($validated);
        return response()->json($exhibition, 201);
    }

    public function show(Exhibition $exhibition)
    {
        return response()->json($exhibition->load('artworks', 'user'));
    }

    public function update(Request $request, Exhibition $exhibition)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'category' => 'nullable|string',
            'status' => 'in:draft,active,ended',
            'is_featured' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exhibition->update($validated);
        return response()->json($exhibition);
    }

    public function destroy(Exhibition $exhibition)
    {
        $exhibition->delete();
        return response()->json(null, 204);
    }
}
