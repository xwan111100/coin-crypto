<?php
// index.php
// ==== RULE #1: FILE EXIST CHECK ====
if (!file_exists("fetch.php")) {
    die("File fetch.php tidak ditemukan!");
}

// ==== RULE #3: VALIDASI API KEY ====
$apiKey = "coinrankingf28d9089eed52bca61534d80d7f1deac00ca224549b0bc22";
if (empty($apiKey)) {
    die("API Key tidak boleh kosong!");
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

// ==== RULE #5: RESPONSE CODE HARUS 200 ====
if ($httpCode !== 200) {
    die("Gagal mengambil data! HTTP Code: $httpCode");
}

// ==== RULE #4: VALID JSON ====
$data = json_decode($response, true);
if (!is_array($data)) {
    die("Response bukan JSON valid!");
}

// ==== AMBIL DATA COIN SECARA AMAN ====
$coins = $data["data"]["coins"] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crypto REST Client</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .coin-icon { width: 45px; height: 45px; object-fit: contain; }
        .spin { animation: spin 6s linear infinite; }
        @keyframes spin { from {transform: rotate(0deg);} to {transform: rotate(360deg);} }
    </style>
</head>

<body class="bg-light">

<!-- ==== NAVBAR STANDAR (SAMA DENGAN CONTACT.PHP) ==== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Crypto REST Client</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="alamat.php">Alamat</a></li>

            </ul>
        </div>
    </div>
</nav>

<!-- ==== LIST COIN ==== -->
<div class="container py-4">
    <h2 class="mb-4 text-center">📊 Daftar Harga Cryptocurrency</h2>

    <div class="row" id="coins-row">
        <?php foreach ($coins as $coin):
            $percent = $coin["change"] ?? 0;
            $icon    = $coin["iconUrl"] ?? "";
            $name    = $coin["name"] ?? "";
            $symbol  = $coin["symbol"] ?? "";
            $price   = $coin["price"] ?? 0;
            $uuid    = $coin["uuid"] ?? uniqid();

            $color   = ($percent >= 0) ? "text-success" : "text-danger";
        ?>
            <div class="col-md-4 mb-4 coin-card" data-uuid="<?= htmlspecialchars($uuid) ?>">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">

                        <img src="<?= htmlspecialchars($icon) ?>" class="coin-icon me-3 spin">

                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($name) ?> (<?= htmlspecialchars($symbol) ?>)</h5>

                            <p class="text-muted mb-1" id="price-<?= htmlspecialchars($uuid) ?>">
                                $<?= number_format((float)$price, 2) ?>
                            </p>

                            <small id="change-<?= htmlspecialchars($uuid) ?>"
                                   class="fw-bold <?= $color ?>">
                                <?= htmlspecialchars($percent) ?>%
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ==== AUTO REFRESH ==== -->
<script>
function refreshData() {
    fetch("fetch.php")
        .then(res => {
            if (!res.ok) throw new Error("Network Error");
            return res.json();
        })
        .then(json => {
            if (!json.data || !json.data.coins) return;

            json.data.coins.forEach(coin => {
                const uuid = coin.uuid;

                const priceEl = document.getElementById("price-" + uuid);
                const changeEl = document.getElementById("change-" + uuid);
                const iconEl = document.querySelector('[data-uuid="'+uuid+'"] img.coin-icon');

                if (priceEl) priceEl.textContent = "$" + Number(coin.price).toFixed(2);
                if (changeEl) {
                    changeEl.textContent = coin.change + "%";
                    changeEl.className = "fw-bold " + (coin.change >= 0 ? "text-success" : "text-danger");
                }
                if (iconEl && coin.iconUrl) iconEl.src = coin.iconUrl;
            });
        })
        .catch(err => console.error("refresh error:", err));
}

setInterval(refreshData, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
