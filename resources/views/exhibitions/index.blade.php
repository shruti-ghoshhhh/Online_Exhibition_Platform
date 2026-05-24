@extends('layouts.app')

@section('title', 'Exhibitions | Lumina')

@section('content')
<div class="container mt-5 mb-5" style="min-height: 60vh;">
    <h1 class="mb-4">Current Exhibitions</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
        @foreach($exhibitions as $exh)
        <div class="card animate-fade-in delay-1">
            <div style="height: 200px; background: #222 url('{{ $exh->banner_image ?? '' }}') center/cover; border-radius: var(--radius-sm); margin-bottom: 20px; position: relative;">
                @if(!$exh->banner_image)
                    <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(212, 175, 55, 0.2), transparent);"></div>
                @endif
            </div>
            <h3 class="mb-1">{{ $exh->title }}</h3>
            <p class="text-muted mb-3">{{ Str::limit($exh->description, 100) }}</p>
            <a href="/exhibitions/{{ $exh->id }}" class="btn btn-outline" style="width: 100%;">View Details</a>
        </div>
        @endforeach
        
        @if($exhibitions->isEmpty())
            <p class="text-muted">No exhibitions available at the moment. Check back soon!</p>
        @endif
    </div>
</div>
@endsection
