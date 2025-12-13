<?php
// fetch.php

// Load .env (untuk LOCAL saja)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$name, $value] = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

// Ambil API Key dari ENV
$apiKey = getenv('COINRANKING_API_KEY');

if (empty($apiKey)) {
    http_response_code(500);
    echo json_encode(['error' => 'API Key tidak ditemukan']);
    exit;
}

$url = "https://api.coinranking.com/v2/coins?limit=20";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-access-token: $apiKey"
    ],
    CURLOPT_SSL_VERIFYPEER => true
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode([
        'error' => 'API error',
        'code' => $httpCode
    ]);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
echo $response;
