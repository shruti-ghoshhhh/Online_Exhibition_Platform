<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exhibition;
use App\Models\Artwork;

class ArtistDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $exhibitions = auth()->user()->exhibitions()->with('artworks')->latest()->get();
        
        $totalLikes = 0;
        $totalComments = 0;
        $totalViews = 0;
        foreach ($exhibitions as $exh) {
            foreach ($exh->artworks as $art) {
                $totalLikes += $art->likes()->count();
                $totalComments += $art->comments()->count();
                $totalViews += $art->views;
            }
        }
        
        $chartLabels = [];
        $chartData = [];
        $artworkIds = $exhibitions->flatMap->artworks->pluck('id');

        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->toDateString();
            $chartLabels[] = \Carbon\Carbon::now()->subDays($i)->format('M d');
            
            $likes = \App\Models\Like::whereIn('artwork_id', $artworkIds)->whereDate('created_at', $date)->count();
            $comments = \App\Models\Comment::whereIn('artwork_id', $artworkIds)->whereDate('created_at', $date)->count();
            
            $chartData[] = $likes + $comments; 
        }
        
        return view('artist.index', compact('exhibitions', 'totalLikes', 'totalComments', 'totalViews', 'chartLabels', 'chartData'));
    }

    public function createExhibition()
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') abort(403);
        return view('artist.create_exhibition');
    }

    public function storeExhibition(Request $request)
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') abort(403);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('banner_image')) {
            $path = '/storage/' . $request->file('banner_image')->store('exhibitions', 'public');
        }

        auth()->user()->exhibitions()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'banner_image' => $path,
            'status' => 'active',
            'is_featured' => false,
            'views' => 0
        ]);

        return redirect('/artist/exhibitions')->with('success', 'Exhibition created successfully!');
    }

    public function showExhibition($id)
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') abort(403);
        $exhibition = auth()->user()->exhibitions()->with('artworks')->findOrFail($id);
        return view('artist.show_exhibition', compact('exhibition'));
    }

    public function createArtwork($id)
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') abort(403);
        $exhibition = auth()->user()->exhibitions()->findOrFail($id);
        return view('artist.create_artwork', compact('exhibition'));
    }

    public function storeArtwork(Request $request, $id)
    {
        if (auth()->user()->role !== 'artist' && auth()->user()->role !== 'admin') abort(403);
        $exhibition = auth()->user()->exhibitions()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $path = '/storage/' . $request->file('image')->store('artworks', 'public');

        $exhibition->artworks()->create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $path,
            'artist_name' => auth()->user()->name,
            'views' => 0
        ]);

        return redirect('/artist/exhibitions/' . $exhibition->id)->with('success', 'Artwork uploaded successfully!');
    }
}
