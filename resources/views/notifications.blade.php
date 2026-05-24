@extends('layouts.app')

@section('title', 'Notifications | Lumina')

@section('content')
<div class="container mt-5" style="min-height: 60vh; max-width: 600px;">
    <h1 class="mb-4">Notifications</h1>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        @foreach($notifications as $notification)
        <a href="{{ $notification->data['url'] ?? '#' }}" class="card animate-fade-in" style="display: block; text-decoration: none; padding: 16px; border: 1px solid {{ $notification->read_at ? 'transparent' : 'rgba(212, 175, 55, 0.3)' }}; {{ $notification->read_at ? 'opacity: 0.7;' : 'background: rgba(212, 175, 55, 0.05);' }}">
            <p style="color: white; font-weight: {{ $notification->read_at ? 'normal' : '500' }}; margin-bottom: 4px;">{{ $notification->data['message'] }}</p>
            <p class="text-muted" style="font-size: 0.8rem;">{{ $notification->created_at->diffForHumans() }}</p>
        </a>
        @endforeach

        @if($notifications->isEmpty())
            <div class="card text-center" style="padding: 32px;">
                <p class="text-muted">You have no new notifications.</p>
            </div>
        @endif
    </div>
</div>
@endsection
