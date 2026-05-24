@extends('layouts.app')

@section('title', 'Dashboard | Lumina')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <h1 class="mb-2">Welcome, {{ auth()->user()->name }}</h1>
    <p class="text-muted mb-5">You are logged in as a <span class="text-accent" style="font-weight: 500;">{{ ucfirst(auth()->user()->role) }}</span>.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
        <div class="card animate-fade-in delay-1">
            <h3 class="mb-2">Your Activity</h3>
            <p class="text-muted">You have 0 saved exhibitions.</p>
            <a href="/exhibitions" class="btn btn-outline mt-3">Discover Art</a>
        </div>
        
        @if(auth()->user()->role === 'artist' || auth()->user()->role === 'admin')
        <div class="card animate-fade-in delay-2">
            <h3 class="mb-2">Artwork Management</h3>
            <p class="text-muted">Upload and manage your digital gallery.</p>
            <a href="/artist/exhibitions" class="btn btn-primary mt-3">Manage Portfolio</a>
        </div>
        @endif
        
        @if(auth()->user()->role === 'admin')
        <div class="card animate-fade-in delay-3" style="border-color: rgba(255, 50, 50, 0.3);">
            <h3 class="mb-2" style="color: #ff6b6b;">Admin Controls</h3>
            <p class="text-muted">Manage users, exhibitions, and platform settings.</p>
            <a href="/admin/dashboard" class="btn btn-outline mt-3" style="border-color: #ff6b6b; color: #ff6b6b;">Go to Admin Panel</a>
        </div>
        @endif
    </div>
</div>
@endsection
