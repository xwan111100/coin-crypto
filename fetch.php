<?php
// fetch.php
$apiKey = "coinrankingf28d9089eed52bca61534d80d7f1deac00ca224549b0bc22";
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
