<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Exhibition;
use App\Models\Artwork;
use App\Models\Registration;
use App\Models\Like;

class AnalyticsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_exhibitions' => Exhibition::count(),
            'total_artworks' => Artwork::count(),
            'total_registrations' => Registration::count(),
            'total_likes' => Like::count(),
            'total_exhibition_views' => Exhibition::sum('views'),
            'total_artwork_views' => Artwork::sum('views'),
        ];
        
        return response()->json($stats);
    }
}
