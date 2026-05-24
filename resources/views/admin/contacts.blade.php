@extends('layouts.app')

@section('title', 'Contact Requests | Admin')

@section('content')
<div class="container mt-5" style="min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-4">
        <h1>Contact Inbox</h1>
        <a href="/admin/dashboard" class="btn btn-outline">Back to Admin Panel</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(50, 255, 100, 0.1); border: 1px solid rgba(50, 255, 100, 0.3); color: #6bff8f; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; gap: 16px;">
        @foreach($contacts as $contact)
        <div class="card {{ $contact->status === 'resolved' ? '' : 'animate-fade-in' }}" style="{{ $contact->status === 'resolved' ? 'opacity: 0.6;' : '' }}">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h4 class="mb-1">{{ $contact->name }} <span style="font-size: 0.9rem; color: var(--text-muted);">({{ $contact->email }})</span></h4>
                    <p class="text-muted mb-2" style="font-size: 0.8rem;">Submitted: {{ $contact->created_at->diffForHumans() }}</p>
                    <p class="mb-3" style="font-family: 'Outfit';">{{ $contact->message }}</p>
                </div>
                @if($contact->status !== 'resolved')
                <form action="/admin/contacts/{{ $contact->id }}/resolve" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline">Mark as Resolved</button>
                </form>
                @else
                <span style="color: #6bff8f;">Resolved ✓</span>
                @endif
            </div>
        </div>
        @endforeach

        @if($contacts->isEmpty())
            <p class="text-muted text-center">No contact requests yet.</p>
        @endif
    </div>
</div>
@endsection
