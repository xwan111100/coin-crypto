 <?php
// index.php
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
    die("Gagal mengambil data dari API! HTTP Code: $httpCode");
}

$data = json_decode($response, true);
$coins = $data["data"]["coins"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crypto REST Client</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .coin-icon {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }
        .spin {
            animation: spin 6s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand fw-bold">Crypto REST Client</span>
    </div>
</nav>

<div class="container py-4">
    <h2 class="mb-4 text-center">📊 Daftar Harga Cryptocurrency</h2>

    <div class="row" id="coins-row">
        <?php foreach ($coins as $coin): 
            // pastikan $percent selalu didefinisikan sebelum dipakai
            $percent = isset($coin['change']) ? $coin['change'] : 0;
            // beberapa field: iconUrl, name, symbol, price, uuid
            $icon = isset($coin['iconUrl']) ? $coin['iconUrl'] : '';
            $name = isset($coin['name']) ? $coin['name'] : '';
            $symbol = isset($coin['symbol']) ? $coin['symbol'] : '';
            $price = isset($coin['price']) ? $coin['price'] : 0;
            $uuid = isset($coin['uuid']) ? $coin['uuid'] : uniqid();
            $colorClass = ($percent >= 0) ? 'text-success' : 'text-danger';
        ?>
            <div class="col-md-4 mb-4 coin-card" data-uuid="<?= htmlspecialchars($uuid) ?>">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= htmlspecialchars($icon) ?>" class="coin-icon me-3 spin" alt="icon">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($name) ?> (<?= htmlspecialchars($symbol) ?>)</h5>
                            <p class="text-muted mb-1" id="price-<?= htmlspecialchars($uuid) ?>">
                                $<?= number_format((float)$price, 2) ?>
                            </p>
                            <small id="change-<?= htmlspecialchars($uuid) ?>" class="fw-bold <?= $colorClass ?>">
                                <?= htmlspecialchars($percent) ?>%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- fetch auto-refresh -->
<script>
function refreshData() {
    fetch('fetch.php')
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
    })
    .then(json => {
        if (!json || !json.data || !json.data.coins) return;
        json.data.coins.forEach(coin => {
            const uuid = coin.uuid;
            const priceEl = document.getElementById('price-' + uuid);
            const changeEl = document.getElementById('change-' + uuid);
            if (priceEl) {
                priceEl.textContent = '$' + Number(coin.price).toFixed(2);
            }
            if (changeEl) {
                changeEl.textContent = coin.change + '%';
                changeEl.className = 'fw-bold ' + (Number(coin.change) >= 0 ? 'text-success' : 'text-danger');
            }
            // update icon if changed
            const card = document.querySelector('[data-uuid="'+uuid+'"] img.coin-icon');
            if (card && coin.iconUrl) card.src = coin.iconUrl;
        });
    })
    .catch(err => {
        console.error('refresh error:', err);
    });
}

// refresh tiap 5 detik
setInterval(refreshData, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
