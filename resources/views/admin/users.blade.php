@extends('layouts.app')

@section('title', 'Manage Users | Admin')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>Manage Users</h1>
        <a href="/admin/dashboard" class="btn btn-outline">Back to Admin Panel</a>
    </div>
    
    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Role</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 12px;">{{ $user->name }}</td>
                    <td style="padding: 12px; color: var(--text-muted);">{{ $user->email }}</td>
                    <td style="padding: 12px;">
                        <form action="/admin/users/{{ $user->id }}/role" method="POST" style="display: flex; gap: 8px;">
                            @csrf
                            <select name="role" style="background: var(--bg-card); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: var(--radius-sm); padding: 4px 8px;">
                                <option value="visitor" {{ $user->role === 'visitor' ? 'selected' : '' }}>Visitor</option>
                                <option value="artist" {{ $user->role === 'artist' ? 'selected' : '' }}>Artist</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-primary" style="padding: 4px 12px; font-size: 0.8rem;">Save</button>
                        </form>
                    </td>
                    <td style="padding: 12px;">
                        @if($user->id !== auth()->id())
                        <form action="/admin/users/{{ $user->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 4px 12px; font-size: 0.8rem; color: #ff6b6b; border-color: #ff6b6b;">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
