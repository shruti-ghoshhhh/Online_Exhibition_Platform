@extends('layouts.app')

@section('title', $exhibition->title . ' | Lumina')

@section('content')
<!-- Pannellum scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

<div class="container mt-5 mb-5">
    <h1 class="mb-2">{{ $exhibition->title }}</h1>
    <p class="text-muted mb-4">{{ $exhibition->description }}</p>
    
    <div class="card animate-fade-in" style="padding: 0; overflow: hidden; height: 600px; position: relative;">
        <div id="panorama" style="width: 100%; height: 100%;"></div>
    </div>
    
    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div style="background: rgba(50, 150, 255, 0.1); border: 1px solid rgba(50, 150, 255, 0.3); color: #6bafff; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('info') }}
        </div>
    @endif

    <div style="display: flex; gap: 16px; margin-top: 24px;">
        <a href="#gallery" class="btn btn-primary">Enter Virtual Gallery</a>
        @auth
            @php
                $isRegistered = $exhibition->registrations()->where('user_id', auth()->id())->exists();
            @endphp
            @if(!$isRegistered)
                <form action="/exhibitions/{{ $exhibition->id }}/register" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline">Register to Attend</button>
                </form>
            @else
                <button class="btn btn-outline" disabled style="opacity: 0.5; cursor: not-allowed; border-color: #6bff8f; color: #6bff8f;">Registered ✓</button>
            @endif
        @else
            <a href="/login" class="btn btn-outline">Log in to Register</a>
        @endauth
    </div>
    
    <div class="mt-5" id="gallery">
        <h2 class="mb-4">Featured Artworks</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 24px;">
            @foreach($exhibition->artworks as $artwork)
            @php 
                $isLiked = auth()->check() ? $artwork->likes()->where('user_id', auth()->id())->exists() : false;
                $likeCount = $artwork->likes()->count();
            @endphp
            <div class="card" onclick="openLightbox({{ $artwork->id }}, '{{ $artwork->image_path }}', '{{ addslashes($artwork->title) }}', '{{ addslashes($artwork->artist_name) }}', {{ $isLiked ? 'true' : 'false' }}, {{ $likeCount }})" style="cursor: pointer;">
                <img src="{{ $artwork->image_path }}" alt="{{ $artwork->title }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--radius-sm); margin-bottom: 12px;">
                <h4 class="mb-1">{{ $artwork->title }}</h4>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p class="text-muted" style="font-size: 0.9rem;">By {{ $artwork->artist_name }}</p>
                    <span style="font-size: 0.8rem; color: var(--accent);">❤️ {{ $likeCount }}</span>
                </div>
            </div>
            @endforeach
            
            @if($exhibition->artworks->isEmpty())
                <p class="text-muted">No artworks uploaded yet.</p>
            @endif
        </div>
    </div>
</div>

<!-- Interactive Lightbox Modal -->
<div id="lightbox" class="hidden" style="position: fixed; inset: 0; background: rgba(0,0,0,0.95); z-index: 2000; display: flex; align-items: stretch; justify-content: center; opacity: 0; transition: var(--transition); padding: 40px;">
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: white; font-size: 2rem; cursor: pointer; z-index: 2010;">&times;</button>
    
    <div style="flex: 3; display: flex; align-items: center; justify-content: center; padding-right: 40px; border-right: 1px solid rgba(255,255,255,0.1);">
        <img id="lb-img" src="" style="max-width: 100%; max-height: 90vh; object-fit: contain; box-shadow: 0 0 50px rgba(212, 175, 55, 0.1);">
    </div>
    
    <div style="flex: 1; min-width: 350px; max-width: 400px; padding-left: 40px; display: flex; flex-direction: column;">
        <h3 id="lb-title" class="mb-1" style="color: var(--accent); font-size: 2rem;"></h3>
        <p id="lb-artist" class="text-muted mb-4" style="font-size: 1.1rem;"></p>
        
        <div class="mb-4 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <button id="lb-like-btn" class="btn btn-outline" style="width: 100%; display: flex; justify-content: center; gap: 8px;">
                <span id="lb-like-icon">🤍</span> <span id="lb-like-count">0 Likes</span>
            </button>
        </div>

        <h4 class="mb-3">Comments</h4>
        <div id="lb-comments-list" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; margin-bottom: 16px; padding-right: 8px;">
            <p class="text-muted" style="font-size: 0.9rem;">Loading comments...</p>
        </div>
        
        @auth
        <div style="display: flex; gap: 8px;">
            <input type="text" id="lb-comment-input" placeholder="Add a comment..." style="flex: 1; background: var(--bg-card); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 10px 14px; border-radius: var(--radius-sm); outline: none; font-family: 'Outfit';">
            <button id="lb-comment-btn" class="btn btn-primary" style="padding: 10px 16px;">Post</button>
        </div>
        @else
        <p class="text-muted" style="font-size: 0.9rem; text-align: center;"><a href="/login" class="text-accent">Log in</a> to like and comment.</p>
        @endauth
    </div>
</div>

<script>
    let currentArtworkId = null;

    document.addEventListener('DOMContentLoaded', () => {
        pannellum.viewer('panorama', {
            "type": "equirectangular",
            "panorama": "https://pannellum.org/images/alma.jpg",
            "autoLoad": true,
            "compass": false,
            "showControls": true
        });
        
        @auth
        document.getElementById('lb-like-btn').addEventListener('click', async () => {
            if (!currentArtworkId) return;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const res = await fetch(`/web-api/artworks/${currentArtworkId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();
            
            document.getElementById('lb-like-count').textContent = data.count + ' Likes';
            document.getElementById('lb-like-icon').textContent = data.status === 'liked' ? '❤️' : '🤍';
        });

        document.getElementById('lb-comment-btn').addEventListener('click', async () => {
            const input = document.getElementById('lb-comment-input');
            const content = input.value.trim();
            if (!content || !currentArtworkId) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch(`/web-api/artworks/${currentArtworkId}/comments`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ content })
            });
            
            if (res.ok) {
                input.value = '';
                loadComments(currentArtworkId); // reload comments
            }
        });
        @endauth
    });
    
    function openLightbox(id, src, title, artist, isLiked, likeCount) {
        currentArtworkId = id;
        document.getElementById('lb-img').src = src;
        document.getElementById('lb-title').textContent = title;
        document.getElementById('lb-artist').textContent = artist ? 'By ' + artist : '';
        
        const likeIcon = isLiked ? '❤️' : '🤍';
        document.getElementById('lb-like-icon').textContent = likeIcon;
        document.getElementById('lb-like-count').textContent = likeCount + ' Likes';
        
        loadComments(id);
        
        const lb = document.getElementById('lightbox');
        lb.classList.remove('hidden');
        setTimeout(() => lb.style.opacity = '1', 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const lb = document.getElementById('lightbox');
        lb.style.opacity = '0';
        setTimeout(() => lb.classList.add('hidden'), 300);
        document.body.style.overflow = '';
        currentArtworkId = null;
    }

    async function loadComments(id) {
        const list = document.getElementById('lb-comments-list');
        list.innerHTML = '<p class="text-muted" style="font-size: 0.9rem;">Loading comments...</p>';
        
        try {
            const res = await fetch(`/web-api/artworks/${id}/comments`);
            const comments = await res.json();
            
            list.innerHTML = '';
            if (comments.length === 0) {
                list.innerHTML = '<p class="text-muted" style="font-size: 0.9rem;">No comments yet. Be the first!</p>';
                return;
            }
            
            comments.forEach(c => {
                list.innerHTML += `
                    <div style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: var(--radius-sm);">
                        <p style="font-weight: 500; font-size: 0.9rem; margin-bottom: 4px; color: var(--accent);">${c.user.name}</p>
                        <p style="font-size: 0.95rem;">${c.body}</p>
                    </div>
                `;
            });
        } catch (e) {
            list.innerHTML = '<p style="color: #ff6b6b; font-size: 0.9rem;">Failed to load comments.</p>';
        }
    }
</script>
<style>
    .hidden { display: none !important; }
</style>
@endsection
