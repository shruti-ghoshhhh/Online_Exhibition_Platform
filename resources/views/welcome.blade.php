@extends('layouts.app')

@section('title', 'Lumina | Discover Virtual Exhibitions')

@section('content')
<div class="hero-section" style="padding: 120px 0 80px; text-align: center; position: relative;">
    <div style="position: absolute; top: -50%; left: 50%; transform: translateX(-50%); width: 800px; height: 800px; background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%); z-index: -1;"></div>
    
    <div class="container animate-fade-in">
        <h1 class="mb-3" style="font-size: 5rem; font-weight: 700;">
            The Future of <br> <span class="text-accent">Digital Art Curation</span>
        </h1>
        <p class="mb-4" style="font-size: 1.2rem; color: var(--text-muted); max-width: 600px; margin-left: auto; margin-right: auto;">
            Explore immersive 360° galleries, connect with visionary artists, and collect pieces that inspire you. Step into the next generation of online exhibitions.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center;">
            <a href="/exhibitions" class="btn btn-primary" style="padding: 16px 32px; font-size: 1.1rem;">Explore Galleries</a>
            <a href="/register" class="btn btn-outline" style="padding: 16px 32px; font-size: 1.1rem;">Join as Artist</a>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center animate-fade-in delay-1">Featured Exhibitions</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;" class="animate-fade-in delay-2">
        @foreach($featured as $exh)
        <div class="card">
            <div style="height: 200px; background: #222 url('{{ $exh->banner_image ?? '' }}') center/cover; border-radius: var(--radius-sm); margin-bottom: 20px; overflow: hidden; position: relative;">
                @if(!$exh->banner_image)
                <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(212, 175, 55, 0.2), transparent);"></div>
                @endif
            </div>
            <h3 class="mb-1">{{ $exh->title }}</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;" class="mb-3">{{ Str::limit($exh->description, 50) }}</p>
            <a href="/exhibitions/{{ $exh->id }}" class="btn btn-outline" style="width: 100%;">Enter Gallery</a>
        </div>
        @endforeach
        
        @if($featured->isEmpty())
            <p class="text-muted">No featured exhibitions right now.</p>
        @endif
    </div>
</div>
@endsection
