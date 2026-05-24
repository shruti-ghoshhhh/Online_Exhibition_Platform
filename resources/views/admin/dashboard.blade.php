@extends('layouts.app')

@section('title', 'Admin Dashboard | Lumina')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="card animate-fade-in">
            <h3 class="mb-2" style="font-size: 3rem; color: var(--accent);">{{ $stats['users'] }}</h3>
            <p class="text-muted">Total Users</p>
        </div>
        <div class="card animate-fade-in delay-1">
            <h3 class="mb-2" style="font-size: 3rem; color: var(--accent);">{{ $stats['exhibitions'] }}</h3>
            <p class="text-muted">Total Exhibitions</p>
        </div>
        <div class="card animate-fade-in delay-2">
            <h3 class="mb-2" style="font-size: 3rem; color: var(--accent);">{{ $stats['artworks'] }}</h3>
            <p class="text-muted">Total Artworks</p>
        </div>
    </div>
    
    <div class="card mb-5 animate-fade-in delay-3">
        <h3 class="mb-3">Platform Growth (Last 7 Days)</h3>
        <canvas id="adminChart" height="80"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('adminChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? []) !!},
                    datasets: [{
                        label: 'New Users & Activity',
                        data: {!! json_encode($chartData ?? []) !!},
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
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
    
    <h3 class="mb-3">Management Tools</h3>
    <div style="display: flex; gap: 16px; margin-bottom: 40px; flex-wrap: wrap;">
        <a href="/admin/users" class="btn btn-primary">Manage Users</a>
        <a href="/admin/exhibitions" class="btn btn-primary">Manage Exhibitions</a>
        <a href="/admin/contacts" class="btn btn-primary">Contact Inbox</a>
    </div>

    <a href="/dashboard" class="btn btn-outline">Back to Main Dashboard</a>
</div>
@endsection
