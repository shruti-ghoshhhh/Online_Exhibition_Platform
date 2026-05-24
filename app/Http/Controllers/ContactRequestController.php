<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(ContactRequest::with('user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactRequest = $request->user()->contactRequests()->create($validated);
        return response()->json($contactRequest, 201);
    }

    public function update(Request $request, ContactRequest $contactRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,done'
        ]);

        $contactRequest->update($validated);
        return response()->json($contactRequest);
    }
}
