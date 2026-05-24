@extends('layouts.app')

@section('title', 'Log In | Lumina')

@section('content')
<div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="card animate-fade-in" style="width: 100%; max-width: 450px;">
        <h2 class="text-center mb-1">Welcome Back</h2>
        <p class="text-center text-muted mb-4">Log in to your Lumina account</p>
        
        @if ($errors->any())
            <div style="background: rgba(255, 50, 50, 0.1); border: 1px solid rgba(255, 50, 50, 0.3); color: #ff6b6b; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            
            <div class="mb-3">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500;">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <div class="mb-4">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">Password</label>
                <input id="password" type="password" name="password" required
                       style="width: 100%; padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: #0a0a0a; color: white; font-family: 'Outfit';">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Log In</button>
        </form>
        
        <p class="text-center mt-4 text-muted">
            Don't have an account? <a href="/register" class="text-accent">Sign up</a>
        </p>
    </div>
</div>
@endsection
