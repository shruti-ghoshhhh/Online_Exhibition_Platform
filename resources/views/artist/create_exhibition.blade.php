@extends('layouts.app')

@section('title', 'Create Exhibition')

@section('content')
<div class="container mt-5" style="min-height: 60vh; max-width: 600px;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>Create New Exhibition</h1>
        <a href="/artist/exhibitions" class="btn btn-outline">Cancel</a>
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
        <form method="POST" action="/artist/exhibitions" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="title" style="display: block; margin-bottom: 8px; font-weight: 500;">Exhibition Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-3">
                <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500;">Description</label>
                <textarea id="description" name="description" rows="4" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="banner_image" style="display: block; margin-bottom: 8px; font-weight: 500;">Banner Image (Optional)</label>
                <input id="banner_image" type="file" name="banner_image" accept="image/*"
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Create Exhibition</button>
        </form>
    </div>
</div>
@endsection
