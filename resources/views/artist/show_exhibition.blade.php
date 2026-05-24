@extends('layouts.app')

@section('title', 'Manage ' . $exhibition->title)

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>{{ $exhibition->title }} <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal;">(Manage Artworks)</span></h1>
        <div>
            <a href="/artist/exhibitions" class="btn btn-outline" style="margin-right: 12px;">Back to Exhibitions</a>
            <a href="/artist/exhibitions/{{ $exhibition->id }}/artworks/create" class="btn btn-primary">Upload Artwork</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 32px;">
        @foreach($exhibition->artworks as $artwork)
        <div class="card animate-fade-in delay-1">
            <img src="{{ $artwork->image_path }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--radius-sm); margin-bottom: 12px;">
            <h3 class="mb-1">{{ $artwork->title }}</h3>
            <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ Str::limit($artwork->description, 50) }}</p>
            <div style="display: flex; justify-content: space-between; margin-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px; font-size: 0.9rem;">
                <span style="color: var(--accent);">❤️ {{ $artwork->likes()->count() }}</span>
                <span style="color: #6bff8f;">💬 {{ $artwork->comments()->count() }}</span>
                <span style="color: var(--text-muted);">👁️ {{ $artwork->views }}</span>
            </div>
        </div>
        @endforeach
        
        @if($exhibition->artworks->isEmpty())
            <div class="card" style="text-align: center; grid-column: 1 / -1;">
                <p class="text-muted mb-3">No artworks uploaded to this exhibition yet.</p>
                <a href="/artist/exhibitions/{{ $exhibition->id }}/artworks/create" class="btn btn-outline">Upload Your First Piece</a>
            </div>
        @endif
    </div>
</div>
@endsection
