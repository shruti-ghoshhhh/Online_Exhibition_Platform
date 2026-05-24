<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    $featured = App\Models\Exhibition::where('is_featured', true)->take(3)->get();
    return view('welcome', compact('featured'));
});

Route::get('/artists', function () {
    $artists = App\Models\User::where('role', 'artist')->get();
    return view('artists', compact('artists'));
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string'
    ]);
    App\Models\ContactRequest::create($validated);
    return back()->with('success', 'Your message has been sent. We will get back to you soon!');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/exhibitions', function () {
    $exhibitions = App\Models\Exhibition::all();
    return view('exhibitions.index', compact('exhibitions'));
});

Route::get('/exhibitions/{id}', function ($id) {
    $exhibition = App\Models\Exhibition::with('artworks')->findOrFail($id);
    return view('exhibitions.show', compact('exhibition'));
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Artist Portfolio Routes
    Route::get('/artist/exhibitions', [\App\Http\Controllers\ArtistDashboardController::class, 'index']);
    Route::get('/artist/exhibitions/create', [\App\Http\Controllers\ArtistDashboardController::class, 'createExhibition']);
    Route::post('/artist/exhibitions', [\App\Http\Controllers\ArtistDashboardController::class, 'storeExhibition']);
    Route::get('/artist/exhibitions/{id}', [\App\Http\Controllers\ArtistDashboardController::class, 'showExhibition']);
    Route::get('/artist/exhibitions/{id}/artworks/create', [\App\Http\Controllers\ArtistDashboardController::class, 'createArtwork']);
    Route::post('/artist/exhibitions/{id}/artworks', [\App\Http\Controllers\ArtistDashboardController::class, 'storeArtwork']);
    
    Route::post('/exhibitions/{id}/register', function($id) {
        $exhibition = App\Models\Exhibition::findOrFail($id);
        $registration = $exhibition->registrations()->where('user_id', auth()->id())->first();
        if (!$registration) {
            $exhibition->registrations()->create(['user_id' => auth()->id()]);
            if($exhibition->user_id !== auth()->id()) {
                $exhibition->user->notify(new \App\Notifications\ActivityNotification(
                    auth()->user()->name . ' registered to attend: ' . $exhibition->title,
                    '/artist/exhibitions/' . $exhibition->id
                ));
            }
            return back()->with('success', 'You have successfully registered for this exhibition!');
        }
        return back()->with('info', 'You are already registered.');
    });

    Route::get('/notifications', function() {
        $notifications = auth()->user()->notifications;
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications', compact('notifications'));
    });

    Route::get('/admin/dashboard', function () {
        if(auth()->user()->role !== 'admin') abort(403);
        $stats = [
            'users' => App\Models\User::count(),
            'exhibitions' => App\Models\Exhibition::count(),
            'artworks' => App\Models\Artwork::count(),
        ];
        
        // Generate last 7 days real data for growth chart
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = App\Models\User::whereDate('created_at', $date->toDateString())->count();
        }

        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartData'));
    });

    // Admin CRUD Routes
    Route::get('/admin/users', [\App\Http\Controllers\AdminDashboardController::class, 'users']);
    Route::post('/admin/users/{id}/role', [\App\Http\Controllers\AdminDashboardController::class, 'updateRole']);
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteUser']);
    
    Route::get('/admin/exhibitions', [\App\Http\Controllers\AdminDashboardController::class, 'exhibitions']);
    Route::post('/admin/exhibitions/{id}/feature', [\App\Http\Controllers\AdminDashboardController::class, 'toggleFeature']);
    Route::delete('/admin/exhibitions/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteExhibition']);
    
    Route::get('/admin/contacts', [\App\Http\Controllers\AdminDashboardController::class, 'contacts']);
    Route::post('/admin/contacts/{id}/resolve', [\App\Http\Controllers\AdminDashboardController::class, 'updateContactStatus']);
    
    // Web API for Likes & Comments
    Route::post('/web-api/artworks/{id}/like', function($id) {
        $artwork = App\Models\Artwork::findOrFail($id);
        $like = $artwork->likes()->where('user_id', auth()->id())->first();
        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked', 'count' => $artwork->likes()->count()]);
        } else {
            $artwork->likes()->create(['user_id' => auth()->id()]);
            if($artwork->user_id !== auth()->id()) {
                $artwork->user->notify(new \App\Notifications\ActivityNotification(
                    auth()->user()->name . ' liked your artwork: ' . $artwork->title,
                    '/exhibitions/' . $artwork->exhibition_id
                ));
            }
            return response()->json(['status' => 'liked', 'count' => $artwork->likes()->count()]);
        }
    });

    Route::get('/web-api/artworks/{id}/comments', function($id) {
        $artwork = App\Models\Artwork::findOrFail($id);
        return response()->json($artwork->comments()->with('user')->latest()->get());
    });

    Route::post('/web-api/artworks/{id}/comments', function(Illuminate\Http\Request $request, $id) {
        $request->validate(['content' => 'required|string']);
        $artwork = App\Models\Artwork::findOrFail($id);
        $comment = $artwork->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->content
        ]);
        if($artwork->user_id !== auth()->id()) {
            $artwork->user->notify(new \App\Notifications\ActivityNotification(
                auth()->user()->name . ' commented on your artwork: ' . $artwork->title,
                '/exhibitions/' . $artwork->exhibition_id
            ));
        }
        $comment->load('user');
        return response()->json($comment);
    });
});
