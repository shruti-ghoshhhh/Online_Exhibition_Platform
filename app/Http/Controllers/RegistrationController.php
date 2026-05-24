<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, Exhibition $exhibition)
    {
        $registration = $exhibition->registrations()->firstOrCreate([
            'user_id' => $request->user()->id
        ]);

        return response()->json($registration, 201);
    }

    public function destroy(Request $request, Exhibition $exhibition)
    {
        $exhibition->registrations()->where('user_id', $request->user()->id)->delete();
        return response()->json(null, 204);
    }
}
