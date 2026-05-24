@extends('layouts.app')

@section('title', 'Manage Exhibitions | Admin')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>Manage Exhibitions</h1>
        <a href="/admin/dashboard" class="btn btn-outline">Back to Admin Panel</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        @foreach($exhibitions as $exh)
        <div class="card animate-fade-in">
            <h3 class="mb-1">{{ $exh->title }}</h3>
            <p class="text-muted mb-2">By {{ $exh->user->name }}</p>
            <p class="mb-4"><span style="color: var(--accent);">{{ $exh->is_featured ? '★ Featured on Homepage' : 'Not Featured' }}</span></p>
            
            <div style="display: flex; gap: 8px;">
                <form action="/admin/exhibitions/{{ $exh->id }}/feature" method="POST" style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">{{ $exh->is_featured ? 'Unfeature' : 'Feature' }}</button>
                </form>
                <form action="/admin/exhibitions/{{ $exh->id }}" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline" style="width: 100%; color: #ff6b6b; border-color: #ff6b6b;">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
