<?php
$apiKey = getenv('COINRANKING_API_KEY');
if (empty($apiKey)) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'COINRANKING_API_KEY environment variable is not set']);
    exit;
}
$url = "https://api.coinranking.com/v2/coins?limit=20";
$headers = ["x-access-token: $apiKey"];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode(['error' => 'API error', 'code' => $httpCode]);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
echo $response;
