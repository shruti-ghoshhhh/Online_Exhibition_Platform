<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $apiKey = env('GROQ_API_KEY');
        
        if (!$apiKey) {
            return response()->json(['error' => 'Groq API Key not configured'], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an AI assistant for an Online Art Exhibition platform. You help visitors with navigation, answer art history questions, and provide exhibition info.'
                ],
                [
                    'role' => 'user',
                    'content' => $request->message
                ]
            ]
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to connect to Groq API'], 500);
    }
}
