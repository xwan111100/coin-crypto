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

// Tentukan halaman aktif
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
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
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .nav-link.active {
            font-weight: bold;
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .about-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .team-card {
            transition: transform 0.3s;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .university-logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?page=home">Crypto REST Client</a>
            <div class="d-flex">
                <a class="nav-link text-white mx-2 <?= $page == 'home' ? 'active' : '' ?>" href="?page=home">Home</a>
                <a class="nav-link text-white mx-2 <?= $page == 'about' ? 'active' : '' ?>" href="?page=about">About</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if ($page == 'home'): ?>
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

            <!-- Script auto-refresh hanya di halaman home -->
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
                                const card = document.querySelector('[data-uuid="' + uuid + '"] img.coin-icon');
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

        <?php elseif ($page == 'about'): ?>
            <div class="about-content">
                <h2 class="mb-4 text-center">📋 Tentang Crypto REST Client</h2>

                <!-- Deskripsi Proyek -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">📋 Deskripsi Proyek</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="section-title">Apa Itu Crypto REST Client?</h5>
                        <p class="mb-3">
                            <strong>Crypto REST Client</strong> adalah sebuah aplikasi web yang dirancang untuk menampilkan
                            informasi harga cryptocurrency secara real-time. Proyek ini bertujuan untuk memberikan
                            akses mudah dan cepat kepada pengguna yang ingin memantau perkembangan pasar cryptocurrency
                            tanpa perlu mengunjungi platform trading yang kompleks.
                        </p>

                        <h5 class="section-title mt-4">Masalah yang Ingin Diselesaikan</h5>
                        <ul class="mb-3">
                            <li><strong>Kompleksitas Platform Trading:</strong> Banyak platform trading cryptocurrency
                                yang terlalu kompleks untuk pemula.</li>
                            <li><strong>Informasi yang Tersebar:</strong> Harga cryptocurrency seringkali tersebar di
                                berbagai platform yang berbeda.</li>
                            <li><strong>Update Tidak Realtime:</strong> Beberapa website hanya memperbarui data setiap
                                beberapa menit atau jam.</li>
                            <li><strong>Aksesibilitas:</strong> Membutuhkan aplikasi yang dapat diakses melalui browser
                                tanpa instalasi tambahan.</li>
                        </ul>

                        <h5 class="section-title mt-4">Teknologi yang Digunakan</h5>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-primary">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-primary">Frontend</h5>
                                        <p class="card-text">
                                            <strong>Bootstrap 5</strong> untuk desain responsif<br>
                                            <strong>JavaScript</strong> untuk interaktivitas<br>
                                            <strong>CSS3</strong> untuk animasi dan styling
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-success">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-success">Backend</h5>
                                        <p class="card-text">
                                            <strong>PHP 7+</strong> untuk pemrosesan server-side<br>
                                            <strong>cURL</strong> untuk komunikasi dengan API<br>
                                            <strong>JSON</strong> untuk pertukaran data
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-warning">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-warning">API & Services</h5>
                                        <p class="card-text">
                                            <strong>Coinranking API</strong> sebagai sumber data<br>
                                            <strong>RESTful Architecture</strong> untuk komunikasi<br>
                                            <strong>AJAX</strong> untuk update real-time
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tim Pengembang -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">👥 Tim Pengembang</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Universitas -->
                        <div class="text-center mb-4">
                            <div class="alert alert-info">
                                <h5 class="mb-2">📚 Institusi Pendidikan</h5>
                                <h4 class="fw-bold text-primary">Universitas Nusantara PGRI Kediri</h4>
                                <p class="mb-0">Proyek ini dikembangkan sebagai bagian dari pembelajaran dan pengembangan skill mahasiswa</p>
                            </div>
                        </div>

                        <h5 class="section-title text-center">Anggota Tim</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card team-card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <span style="font-size: 30px;">👨‍💻</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Eko Setiawan</h5>
                                        <p class="card-text text-muted">Lead Developer & Project Manager</p>
                                        <small class="text-primary">Bertanggung jawab atas arsitektur sistem dan koordinasi tim</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card team-card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <span style="font-size: 30px;">💻</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Moh. Aqbil Asyfa'</h5>
                                        <p class="card-text text-muted">Backend Developer</p>
                                        <small class="text-primary">Mengembangkan logika server-side dan integrasi API</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card team-card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <span style="font-size: 30px;">🎨</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Ahmad Qolbi Rendi F</h5>
                                        <p class="card-text text-muted">Frontend Developer & UI/UX Designer</p>
                                        <small class="text-primary">Mendesain interface dan mengimplementasikan frontend</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card team-card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <span style="font-size: 30px;">📝</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Hanny Novitasari</h5>
                                        <p class="card-text text-muted">Documentation & Testing Specialist</p>
                                        <small class="text-primary">Membuat dokumentasi dan melakukan pengujian sistem</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 d-flex justify-content-center">
                                <div class="card team-card h-100" style="width: 100%; max-width: 500px;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                        <div class="mb-3">
                                            <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 80px; height: 80px;">
                                                <span style="font-size: 30px;">📝</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Rizki Fajar Kurniawan</h5>
                                        <p class="card-text text-muted">Penambahan Tools</p>
                                        <small class="text-primary">Menambahkan Tools</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-secondary mt-4">
                                <h6 class="mb-2">🏆 Visi Tim</h6>
                                <p class="mb-0">
                                    "Menghasilkan solusi teknologi yang bermanfaat dan mudah diakses oleh masyarakat,
                                    sambil terus mengembangkan kemampuan teknis dan kolaborasi tim dalam dunia pengembangan web."
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="?page=home" class="btn btn-primary btn-lg">
                            ← Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>