<?php
/**
 * Test Environment Variables - Verifikasi konfigurasi COINRANKING_API_KEY
 * 
 * Buka di browser: http://localhost/coin-crypto/test_env.php
 * 
 * Jika COINRANKING_API_KEY tidak terlihat, pastikan:
 * 1. Windows System Environment Variable sudah di-set
 * 2. Apache sudah di-restart setelah set env var
 * 3. Atau gunakan SetEnv di httpd.conf / .htaccess
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Environment Variables Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: monospace; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        .success { color: green; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { text-align: left; padding: 10px; border: 1px solid #ddd; }
        th { background: #f0f0f0; }
        code { background: #f5f5f5; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
<div class="container">
    <h2>🔍 Environment Variables Verification</h2>
    
    <?php
    $apiKey = getenv('COINRANKING_API_KEY');
    $apiKeyServer = isset($_SERVER['COINRANKING_API_KEY']) ? $_SERVER['COINRANKING_API_KEY'] : null;
    ?>
    
    <h3>1. getenv() Method:</h3>
    <p>
        <code>getenv('COINRANKING_API_KEY')</code>: 
        <?php if ($apiKey): ?>
            <span class="success">✓ SET</span> → 
            <code><?php echo htmlspecialchars(substr($apiKey, 0, 10)) . '...'; ?></code> (partial)
        <?php else: ?>
            <span class="error">✗ NOT SET</span>
        <?php endif; ?>
    </p>
    
    <h3>2. $_SERVER[] Method:</h3>
    <p>
        <code>$_SERVER['COINRANKING_API_KEY']</code>: 
        <?php if ($apiKeyServer): ?>
            <span class="success">✓ SET</span> → 
            <code><?php echo htmlspecialchars(substr($apiKeyServer, 0, 10)) . '...'; ?></code> (partial)
        <?php else: ?>
            <span class="error">✗ NOT SET</span>
        <?php endif; ?>
    </p>
    
    <h3>3. Server Info:</h3>
    <table>
        <tr>
            <th>Parameter</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>PHP Version</td>
            <td><code><?php echo phpversion(); ?></code></td>
        </tr>
        <tr>
            <td>Server Software</td>
            <td><code><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE']); ?></code></td>
        </tr>
        <tr>
            <td>Current Working Dir</td>
            <td><code><?php echo htmlspecialchars(getcwd()); ?></code></td>
        </tr>
    </table>
    
    <h3>4. Diagnosis:</h3>
    <?php if ($apiKey || $apiKeyServer): ?>
        <p><span class="success">✓ API Key tersedia!</span> Aplikasi seharusnya berfungsi dengan baik.</p>
    <?php else: ?>
        <p><span class="error">✗ API Key tidak ditemukan.</span> Langkah yang harus dilakukan:</p>
        <ol>
            <li>Pilih salah satu cara untuk set <code>COINRANKING_API_KEY</code>:
                <ul>
                    <li><strong>Opsi A (Windows System Env)</strong>: Buka Settings → System → Environment Variables → New
                        <ul>
                            <li>Name: <code>COINRANKING_API_KEY</code></li>
                            <li>Value: <code>your_api_key_here</code></li>
                        </ul>
                    </li>
                    <li><strong>Opsi B (httpd.conf)</strong>: Edit <code>C:\xampp\apache\conf\httpd.conf</code> dan tambahkan:
                        <pre>SetEnv COINRANKING_API_KEY "your_api_key_here"</pre>
                    </li>
                    <li><strong>Opsi C (.htaccess)</strong>: Buat/edit <code>.htaccess</code> di folder project:
                        <pre>SetEnv COINRANKING_API_KEY "your_api_key_here"</pre>
                    </li>
                </ul>
            </li>
            <li><strong>Restart Apache</strong> via XAMPP Control Panel (Stop → Start)</li>
            <li><strong>Refresh halaman ini</strong> (Ctrl+F5)</li>
        </ol>
    <?php endif; ?>
    
    <h3>5. Alternative Check (PHP -r):</h3>
    <p>Jika ingin cek dari command line:</p>
    <pre>php -r "echo getenv('COINRANKING_API_KEY');"</pre>
    
</div>
</body>
</html>