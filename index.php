<?php
$apiKey = "coinrankingf28d9089eed52bca61534d80d7f1deac00ca224549b0bc22";

$url = "https://api.coinranking.com/v2/coins?limit=20";
$headers = [
    "x-access-token: $apiKey"
];

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

// CoinRanking structure:
// $data["data"]["coins"]
$coins = $data["data"]["coins"];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto REST Client</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .coin-icon {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand fw-bold">Crypto REST Client</span>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <h2 class="mb-4 text-center">📊 Daftar Harga Cryptocurrency</h2>

        <div class="row">

            <?php foreach ($coins as $coin): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">

                            <!-- Icon Crypto -->
                            <img src="<?= $coin['iconUrl'] ?>" class="coin-icon me-3" alt="icon">

                            <div>
                                <h5 class="mb-1"><?= $coin['name'] ?> (<?= $coin['symbol'] ?>)</h5>

                                <!-- Harga -->
                                <p class="text-muted mb-1">
                                    $<?= number_format($coin['price'], 2) ?>
                                </p>

                                <!-- Persentase berubah -->
                                <?php
                                $percent = $coin['change'];
                                $color = $percent >= 0 ? "text-success" : "text-danger";
                                ?>
                                <small class="fw-bold <?= $color ?>">
                                    <?= $percent ?>%
                                </small>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>