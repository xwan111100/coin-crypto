<?php
/**
 * Debug API connection - test HTTP 401 issue
 */

$apiKey = getenv('COINRANKING_API_KEY');
echo "=== API Debug ===\n";
echo "API Key from env: " . htmlspecialchars(substr($apiKey, 0, 15)) . "...\n";
echo "Key length: " . strlen($apiKey) . "\n\n";

$url = "https://api.coinranking.com/v2/coins?limit=1";
echo "URL: $url\n";
echo "Header: x-access-token: " . htmlspecialchars(substr($apiKey, 0, 15)) . "...\n\n";

$headers = ["x-access-token: {$apiKey}"];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10
]);

echo "Sending request...\n";
$body = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);
curl_close($curl);

echo "HTTP Code: $code\n";
if ($error) {
    echo "cURL Error: $error\n";
}
echo "\nResponse (first 300 chars):\n";
echo substr($body, 0, 300) . "\n";

if ($code === 401) {
    echo "\n⚠️  HTTP 401 Unauthorized:\n";
    echo "- API Key might be invalid or expired\n";
    echo "- Check if key is correct in CoinRanking dashboard\n";
    echo "- Try generating a new key if this one was compromised\n";
}
?>
