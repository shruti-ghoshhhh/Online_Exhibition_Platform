<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exhibition;
use App\Models\ContactRequest;

class AdminDashboardController extends Controller
{
    public function users()
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated.');
    }

    public function deleteUser($id)
    {
        if(auth()->user()->role !== 'admin') abort(403);
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted.');
    }

    public function exhibitions()
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $exhibitions = Exhibition::with('user')->latest()->get();
        return view('admin.exhibitions', compact('exhibitions'));
    }

    public function toggleFeature($id)
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $exhibition = Exhibition::findOrFail($id);
        $exhibition->update(['is_featured' => !$exhibition->is_featured]);
        return back()->with('success', 'Exhibition featured status updated.');
    }

    public function deleteExhibition($id)
    {
        if(auth()->user()->role !== 'admin') abort(403);
        Exhibition::findOrFail($id)->delete();
        return back()->with('success', 'Exhibition deleted.');
    }

    public function contacts()
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $contacts = ContactRequest::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function updateContactStatus($id)
    {
        if(auth()->user()->role !== 'admin') abort(403);
        $contact = ContactRequest::findOrFail($id);
        $contact->update(['status' => 'resolved']);
        return back()->with('success', 'Contact request marked as resolved.');
    }
}
