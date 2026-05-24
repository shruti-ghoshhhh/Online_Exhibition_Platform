@extends('layouts.app')

@section('title', 'Join Lumina')

@section('content')
<div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh; margin-top: 40px; margin-bottom: 40px;">
    <div class="card animate-fade-in" style="width: 100%; max-width: 500px;">
        <h2 class="text-center mb-1">Create an Account</h2>
        <p class="text-center text-muted mb-4">Join the future of digital art</p>
        
        @if ($errors->any())
            <div style="background: rgba(255, 50, 50, 0.1); border: 1px solid rgba(255, 50, 50, 0.3); color: #ff6b6b; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            
            <div class="mb-3">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500;">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-3">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500;">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>
            
            <div class="mb-3">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">I am a...</label>
                <div style="display: flex; gap: 16px;">
                    <label style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); text-align: center; cursor: pointer;">
                        <input type="radio" name="role" value="visitor" checked style="margin-right: 8px;"> Visitor
                    </label>
                    <label style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); text-align: center; cursor: pointer;">
                        <input type="radio" name="role" value="artist" style="margin-right: 8px;"> Artist
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">Password</label>
                <input id="password" type="password" name="password" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500;">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
        </form>
        
        <p class="text-center mt-4 text-muted">
            Already have an account? <a href="/login" class="text-accent">Log in</a>
        </p>
    </div>
</div>
@endsection
