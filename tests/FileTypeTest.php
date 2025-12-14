<?php
use PHPUnit\Framework\TestCase;

class FileTypeTest extends TestCase
{
    private $apiKey;
    private $apiUrl = "https://api.coinranking.com/v2/coins?limit=1";

    protected function setUp(): void
    {
        // API key must be provided via environment variable to avoid committing secrets
        $this->apiKey = getenv("COINRANKING_API_KEY");
    }

    /** a. File exist */
    public function test_index_php_exists()
    {
        $this->assertFileExists("index.php", "File index.php tidak ditemukan!");
    }

    /** b. valid syntax */
    public function test_index_php_syntax_valid()
    {
        $output = null;
        $result = null;
        exec("php -l index.php", $output, $result);
        $this->assertEquals(0, $result, "Syntax error pada index.php");
    }

    /** c. API Key tidak boleh kosong */
    public function test_api_key_not_empty()
    {
        $this->assertNotEmpty($this->apiKey, "API Key kosong!");
    }

    /** d. Valid JSON response */
    public function test_api_json_valid()
    {
        $response = $this->curlGet($this->apiUrl);
        $json = json_decode($response["body"], true);
        $this->assertIsArray($json, "Response bukan JSON valid!");
    }

    /** e. Response code harus 200 */
    public function test_api_response_200()
    {
        $response = $this->curlGet($this->apiUrl);
        $this->assertEquals(200, $response["code"], "Response code API bukan 200!");
    }

    private function curlGet($url)
    {
        $headers = ["x-access-token: {$this->apiKey}"];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $body = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return ["body" => $body, "code" => $code];
    }
}
