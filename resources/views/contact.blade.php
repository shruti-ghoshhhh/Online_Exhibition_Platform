@extends('layouts.app')

@section('title', 'Contact Us | Lumina')

@section('content')
<div class="container mt-5" style="min-height: 60vh; max-width: 600px;">
    <h1 class="mb-4">Contact Admin</h1>
    <p class="text-muted mb-4">Are you a gallery owner or event organizer looking to partner with Lumina? Send us a message!</p>

    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card animate-fade-in">
        <form method="POST" action="/contact">
            @csrf
            
            <div class="mb-3">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500;">Your Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-3">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500;">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-4">
                <label for="message" style="display: block; margin-bottom: 8px; font-weight: 500;">Message</label>
                <textarea id="message" name="message" rows="5" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">{{ old('message') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
        </form>
    </div>
</div>
@endsection
