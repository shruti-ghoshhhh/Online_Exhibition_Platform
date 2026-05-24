@extends('layouts.app')

@section('title', 'My Portfolio | Lumina')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>My Exhibitions</h1>
        <a href="/artist/exhibitions/create" class="btn btn-primary">Create Exhibition</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Analytics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div class="card" style="padding: 16px;">
            <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 4px;">{{ $totalLikes ?? 0 }}</h3>
            <p class="text-muted" style="font-size: 0.9rem;">Total Likes</p>
        </div>
        <div class="card" style="padding: 16px;">
            <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 4px;">{{ $totalComments ?? 0 }}</h3>
            <p class="text-muted" style="font-size: 0.9rem;">Total Comments</p>
        </div>
        <div class="card" style="padding: 16px;">
            <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 4px;">{{ $totalViews ?? 0 }}</h3>
            <p class="text-muted" style="font-size: 0.9rem;">Artwork Views</p>
        </div>
    </div>

    <!-- Analytics Chart -->
    <div class="card mb-5 animate-fade-in delay-2">
        <h3 class="mb-3">Artwork Engagement (Last 7 Days)</h3>
        <canvas id="artistChart" height="80"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('artistChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? []) !!},
                    datasets: [{
                        label: 'Engagement (Likes + Comments)',
                        data: {!! json_encode($chartData ?? []) !!},
                        borderColor: '#6bff8f',
                        backgroundColor: 'rgba(107, 255, 143, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#a0a0a0' } },
                        x: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#a0a0a0' } }
                    },
                    plugins: {
                        legend: { labels: { color: '#f0f0f0' } }
                    }
                }
            });
        });
    </script>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
        @foreach($exhibitions as $exh)
        <div class="card animate-fade-in delay-1">
            <div style="height: 150px; background: #222 url('{{ $exh->banner_image ?? '' }}') center/cover; border-radius: var(--radius-sm); margin-bottom: 20px; position: relative;"></div>
            <h3 class="mb-1">{{ $exh->title }}</h3>
            <p class="text-muted mb-3">{{ $exh->artworks->count() }} Artworks</p>
            <a href="/artist/exhibitions/{{ $exh->id }}" class="btn btn-outline" style="width: 100%;">Manage Artworks</a>
        </div>
        @endforeach
        
        @if($exhibitions->isEmpty())
            <div class="card" style="text-align: center; grid-column: 1 / -1;">
                <p class="text-muted mb-3">You haven't created any exhibitions yet.</p>
                <a href="/artist/exhibitions/create" class="btn btn-outline">Start Your First Exhibition</a>
            </div>
        @endif
    </div>
</div>
@endsection
