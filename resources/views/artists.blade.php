@extends('layouts.app')

@section('title', 'Artists | Lumina')

@section('content')
<div class="container mt-5 mb-5" style="min-height: 60vh;">
    <h1 class="mb-4">Featured Artists</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 32px;">
        @foreach($artists as $artist)
        <div class="card animate-fade-in delay-1" style="text-align: center;">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--accent); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #000; font-weight: bold;">
                {{ substr($artist->name, 0, 1) }}
            </div>
            <h3 class="mb-1">{{ $artist->name }}</h3>
            <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ Str::limit($artist->bio, 80) }}</p>
            <a href="/exhibitions" class="btn btn-outline" style="width: 100%;">View Works</a>
        </div>
        @endforeach
        
        @if($artists->isEmpty())
            <p class="text-muted">No artists registered yet.</p>
        @endif
    </div>
</div>
@endsection
