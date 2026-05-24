<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GROQ_API_KEY'] ?? getenv('GROQ_API_KEY');
echo "Key: " . substr($apiKey, 0, 5) . "...\n";

$ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . trim($apiKey),
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'llama3-8b-8192',
    'messages' => [
        ['role' => 'user', 'content' => 'hi']
    ]
]));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local testing

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
echo "HTTP Code: $httpCode\n";
echo "Error: $error\n";
echo "Response: $response\n";
curl_close($ch);
