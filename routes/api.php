<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('exhibitions', ExhibitionController::class);
    Route::apiResource('exhibitions.artworks', ArtworkController::class);
    
    // Phase 3 routes
    Route::post('exhibitions/{exhibition}/register', [RegistrationController::class, 'store']);
    Route::delete('exhibitions/{exhibition}/register', [RegistrationController::class, 'destroy']);
    
    Route::post('likes', [LikeController::class, 'store']);
    Route::delete('likes/{like}', [LikeController::class, 'destroy']);
    
    Route::get('artworks/{artwork}/comments', [CommentController::class, 'index']);
    Route::post('artworks/{artwork}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    
    // Phase 4 routes (Admin & Contact)
    Route::get('contact-requests', [App\Http\Controllers\ContactRequestController::class, 'index']);
    Route::post('contact-requests', [App\Http\Controllers\ContactRequestController::class, 'store']);
    Route::put('contact-requests/{contactRequest}', [App\Http\Controllers\ContactRequestController::class, 'update']);
    
    Route::get('admin/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index']);
    Route::apiResource('admin/users', App\Http\Controllers\Admin\UserController::class);
});

// Phase 5 routes (AI Bot)
Route::post('chatbot/ask', [App\Http\Controllers\ChatBotController::class, 'ask']);
