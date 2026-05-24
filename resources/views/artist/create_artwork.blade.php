@extends('layouts.app')

@section('title', 'Upload Artwork')

@section('content')
<div class="container mt-5" style="min-height: 60vh; max-width: 600px;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>Upload Artwork</h1>
        <a href="/artist/exhibitions/{{ $exhibition->id }}" class="btn btn-outline">Cancel</a>
    </div>

    @if ($errors->any())
        <div style="background: rgba(255, 50, 50, 0.1); border: 1px solid rgba(255, 50, 50, 0.3); color: #ff6b6b; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            <ul style="margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card animate-fade-in">
        <form method="POST" action="/artist/exhibitions/{{ $exhibition->id }}/artworks" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="title" style="display: block; margin-bottom: 8px; font-weight: 500;">Artwork Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-3">
                <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500;">Description</label>
                <textarea id="description" name="description" rows="3" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="image" style="display: block; margin-bottom: 8px; font-weight: 500;">High-Res Image (Required)</label>
                <input id="image" type="file" name="image" accept="image/*" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Upload Artwork</button>
        </form>
    </div>
</div>
@endsection
