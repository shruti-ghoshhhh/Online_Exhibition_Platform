<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Lumina | Online Art Exhibition')</title>
    
    <!-- Meta Descriptions for SEO -->
    <meta name="description" content="Discover premium virtual art exhibitions, connect with artists, and explore breathtaking galleries.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <a href="/" class="nav-brand">Lumina<span>.</span></a>
            
            <nav class="nav-links">
                <a href="/exhibitions" class="nav-link">Exhibitions</a>
                <a href="/artists" class="nav-link">Artists</a>
                @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <a href="/contact" class="nav-link">Contact</a>
                @endif
                
                @auth
                    @php
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    <a href="/notifications" class="nav-link" style="position: relative; display: inline-flex; align-items: center; padding-right: 24px;">
                        🔔 
                        @if($unreadCount > 0)
                        <span style="position: absolute; top: -5px; right: 0px; background: #ff6b6b; color: white; font-size: 0.7rem; font-weight: bold; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/dashboard" class="nav-link" style="color: #ff6b6b; font-weight: 600;">Admin Panel</a>
                    @endif
                    
                    @if(auth()->user()->role === 'artist')
                        <a href="/artist/exhibitions" class="nav-link" style="color: var(--accent); font-weight: 600;">Artist Dashboard</a>
                    @endif
                    
                    <a href="/dashboard" class="btn btn-primary" style="margin-left: 12px;">Dashboard</a>

                    <form method="POST" action="/logout" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.9rem;">Log Out</button>
                    </form>
                @else
                    <a href="/login" class="nav-link">Log In</a>
                    <a href="/register" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="margin-top: 80px; padding: 40px 0; border-top: 1px solid rgba(255,255,255,0.05); text-align: center; color: var(--text-muted);">
        <div class="container">
            <p>&copy; {{ date('Y') }} Lumina Art Exhibitions. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Floating AI Chat Widget placeholder -->
    <div id="ai-chat-widget"></div>
</body>
</html>
