<?php
// news.php - Halaman Berita Cryptocurrency

// API Key untuk berita (contoh menggunakan NewsAPI)
// Dapatkan API key gratis di: https://newsapi.org/
$newsApiKey = "coinrankingf28d9089eed52bca61534d80d7f1deac00ca224549b0bc22"; // Ganti dengan API key Anda

// Kategori berita yang tersedia
$categories = [
    '' => 'Semua Kategori',
    'business' => 'Bisnis',
    'entertainment' => 'Hiburan',
    'general' => 'Umum',
    'health' => 'Kesehatan',
    'science' => 'Sains',
    'sports' => 'Olahraga',
    'technology' => 'Teknologi'
];

// Sumber berita cryptocurrency populer
$sources = [
    'coindesk' => 'CoinDesk',
    'cointelegraph' => 'CoinTelegraph',
    'cryptonews' => 'CryptoNews',
    'bitcoinist' => 'Bitcoinist',
    'newsbtc' => 'NewsBTC'
];

// Ambil parameter pencarian
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : 'cryptocurrency';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$source = isset($_GET['source']) ? trim($_GET['source']) : '';

// Quick search keywords
$quickSearches = ['Bitcoin', 'Ethereum', 'Blockchain', 'NFT', 'DeFi', 'Web3', 'Crypto', 'Trading'];

// Jika NewsAPI key tersedia, ambil data
$articles = [];
$totalResults = 0;

if ($newsApiKey !== "YOUR_NEWSAPI_KEY_HERE" && !empty($newsApiKey)) {
    // Bangun URL untuk NewsAPI
    $url = "https://newsapi.org/v2/everything?q=" . urlencode($searchQuery) . "&language=en&sortBy=publishedAt&apiKey=" . $newsApiKey;
    
    // Tambahkan kategori jika dipilih
    if (!empty($category)) {
        $url .= "&category=" . urlencode($category);
    }
    
    // Batasi jumlah artikel
    $url .= "&pageSize=12";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $newsData = json_decode($response, true);
        $articles = $newsData["articles"] ?? [];
        $totalResults = $newsData["totalResults"] ?? 0;
    }
} else {
    // Fallback: Data dummy untuk demo
    $articles = getDummyNews();
    $totalResults = count($articles);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Cryptocurrency - Crypto REST Client</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        .news-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e9ecef;
            height: 100%;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .news-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .badge-crypto {
            background: linear-gradient(45deg, #6f42c1, #0d6efd);
            color: white;
        }
        .search-box {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .result-info {
            background: #e8f4fd;
            border-left: 4px solid #0d6efd;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .source-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
        }
        .quick-search-btn {
            border-radius: 20px;
            padding: 6px 15px;
            transition: all 0.3s;
            margin: 2px;
        }
        .quick-search-btn:hover {
            transform: scale(1.05);
        }
        .news-title {
            height: 60px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .news-desc {
            height: 72px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .loading-spinner {
            display: none;
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body class="bg-light">

<!-- NAVBAR KONSISTEN -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-currency-bitcoin"></i> Crypto REST Client
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        <i class="bi bi-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="news.php">
                        <i class="bi bi-newspaper"></i> News
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="bi bi-newspaper text-primary"></i> Berita Cryptocurrency
            </h1>
            <?php if (!empty($searchQuery) && $searchQuery !== 'cryptocurrency'): ?>
                <p class="lead">Hasil pencarian untuk: <span class="text-primary fw-bold">"<?= htmlspecialchars($searchQuery) ?>"</span></p>
            <?php else: ?>
                <p class="lead text-muted">Berita terkini seputar dunia cryptocurrency dan blockchain</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-end">
            <div class="result-info">
                <i class="bi bi-info-circle me-2"></i> 
                <strong><?= $totalResults ?></strong> berita ditemukan
                <?php if ($newsApiKey === "YOUR_NEWSAPI_KEY_HERE"): ?>
                    <br><small class="text-warning"><i class="bi bi-exclamation-triangle"></i> Mode demo</small>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- FORM PENCARIAN -->
    <div class="search-box">
        <h4 class="mb-4">
            <i class="bi bi-search text-primary"></i> Pencarian Berita
        </h4>
        
        <form method="GET" action="news.php" class="row g-3" id="newsForm">
            <!-- Input Kata Kunci -->
            <div class="col-md-6">
                <label for="search" class="form-label fw-bold">
                    <i class="bi bi-keyboard"></i> Kata Kunci
                </label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="<?= htmlspecialchars($searchQuery) ?>"
                           placeholder="Cari berita cryptocurrency..."
                           aria-label="Kata kunci pencarian">
                </div>
                <div class="form-text mt-2">
                    <i class="bi bi-lightbulb"></i> Contoh: Bitcoin, Ethereum, Blockchain, NFT, dll.
                </div>
            </div>
            
            <!-- Dropdown Kategori -->
            <div class="col-md-3">
                <label for="category" class="form-label fw-bold">
                    <i class="bi bi-tags"></i> Kategori
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-filter"></i>
                    </span>
                    <select class="form-select" id="category" name="category">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $key => $value): ?>
                            <?php if (!empty($key)): ?>
                                <option value="<?= $key ?>" <?= $category == $key ? 'selected' : '' ?>>
                                    <?= $value ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Dropdown Sumber -->
            <div class="col-md-3">
                <label for="source" class="form-label fw-bold">
                    <i class="bi bi-newspaper"></i> Sumber
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-building"></i>
                    </span>
                    <select class="form-select" id="source" name="source">
                        <option value="">Semua Sumber</option>
                        <?php foreach ($sources as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $source == $key ? 'selected' : '' ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <button type="submit" class="btn btn-primary btn-lg px-4" id="searchBtn">
                            <i class="bi bi-search me-2"></i> Cari Berita
                        </button>
                        <button type="button" onclick="clearSearch()" class="btn btn-outline-secondary btn-lg ms-2">
                            <i class="bi bi-arrow-clockwise me-2"></i> Reset
                        </button>
                    </div>
                    <div class="spinner-border text-primary loading-spinner" role="status" id="loadingSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- QUICK SEARCH TAGS -->
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="mb-3">
                <i class="bi bi-lightning-charge text-warning"></i> Pencarian Cepat:
            </h6>
            <div class="d-flex flex-wrap">
                <?php foreach ($quickSearches as $quick): ?>
                    <a href="news.php?search=<?= urlencode($quick) ?>" 
                       class="btn btn-sm quick-search-btn 
                              <?= $searchQuery === $quick ? 'btn-primary' : 'btn-outline-primary' ?>">
                        <?= $quick ?>
                        <?php if ($searchQuery === $quick): ?>
                            <i class="bi bi-check-circle ms-1"></i>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- TAMPILAN BERITA -->
    <div class="row" id="newsContainer">
        <?php if (empty($articles)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-5 my-5">
                    <div class="py-4">
                        <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                        <h3 class="mt-4">Tidak ada berita ditemukan</h3>
                        <p class="lead">Coba gunakan kata kunci yang berbeda atau kunjungi sumber berita berikut:</p>
                        <div class="mt-4">
                            <a href="https://www.coindesk.com" target="_blank" class="btn btn-outline-dark me-2">
                                <i class="bi bi-box-arrow-up-right"></i> CoinDesk
                            </a>
                            <a href="https://cointelegraph.com" target="_blank" class="btn btn-outline-dark me-2">
                                <i class="bi bi-box-arrow-up-right"></i> CoinTelegraph
                            </a>
                            <a href="https://cryptonews.com" target="_blank" class="btn btn-outline-dark">
                                <i class="bi bi-box-arrow-up-right"></i> CryptoNews
                            </a>
                        </div>
                        <?php if ($newsApiKey === "YOUR_NEWSAPI_KEY_HERE"): ?>
                            <div class="alert alert-info mt-4">
                                <h5><i class="bi bi-info-circle"></i> Mode Demo Aktif</h5>
                                <p>Untuk mendapatkan berita real-time, silakan:</p>
                                <ol>
                                    <li>Daftar di <a href="https://newsapi.org" target="_blank">NewsAPI.org</a> (gratis)</li>
                                    <li>Dapatkan API key</li>
                                    <li>Ganti <code>YOUR_NEWSAPI_KEY_HERE</code> di baris 9 dengan API key Anda</li>
                                </ol>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($articles as $index => $article): 
                $title = htmlspecialchars($article['title'] ?? 'Tanpa judul');
                $description = htmlspecialchars($article['description'] ?? 'Tidak ada deskripsi');
                $url = htmlspecialchars($article['url'] ?? '#');
                $image = htmlspecialchars($article['urlToImage'] ?? 'https://via.placeholder.com/400x200/6f42c1/ffffff?text=Crypto+News');
                $source = htmlspecialchars($article['source']['name'] ?? $article['source'] ?? 'Unknown');
                $date = isset($article['publishedAt']) ? date('d M Y, H:i', strtotime($article['publishedAt'])) : 'Tanggal tidak tersedia';
                $author = htmlspecialchars($article['author'] ?? 'Unknown Author');
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card news-card">
                        <!-- Badge Trending untuk 3 artikel pertama -->
                        <?php if ($index < 3): ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">
                                    <i class="bi bi-fire"></i> Trending
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Gambar Berita -->
                        <img src="<?= $image ?>" 
                             class="card-img-top news-img" 
                             alt="<?= $title ?>"
                             onerror="this.src='https://via.placeholder.com/400x200/6f42c1/ffffff?text=Crypto+News'">
                        
                        <!-- Badge Sumber -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge badge-crypto source-badge">
                                <?= $source ?>
                            </span>
                        </div>
                        
                        <!-- Konten Berita -->
                        <div class="card-body d-flex flex-column">
                            <!-- Judul -->
                            <h5 class="card-title news-title">
                                <?= $title ?>
                            </h5>
                            
                            <!-- Deskripsi -->
                            <p class="card-text text-muted news-desc">
                                <?= $description ?>
                            </p>
                            
                            <!-- Metadata -->
                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> <?= $author ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> <?= $date ?>
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Tombol Baca -->
                            <a href="<?= $url ?>" 
                               target="_blank" 
                               class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-box-arrow-up-right me-2"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- PAGINATION -->
    <?php if ($totalResults > 12): ?>
    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">
                    <i class="bi bi-chevron-left"></i> Previous
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="news.php?search=<?= urlencode($searchQuery) ?>&page=2">2</a></li>
            <li class="page-item"><a class="page-link" href="news.php?search=<?= urlencode($searchQuery) ?>&page=3">3</a></li>
            <li class="page-item">
                <a class="page-link" href="news.php?search=<?= urlencode($searchQuery) ?>&page=2">
                    Next <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- INFO API -->
    <?php if ($newsApiKey === "YOUR_NEWSAPI_KEY_HERE"): ?>
    <div class="alert alert-warning mt-4">
        <h5><i class="bi bi-exclamation-triangle"></i> Peringatan: Mode Demo</h5>
        <p>Halaman ini saat ini menggunakan data dummy. Untuk berita real-time:</p>
        <ol>
            <li>Kunjungi <a href="https://newsapi.org/register" target="_blank">NewsAPI.org</a> dan daftar (gratis)</li>
            <li>Dapatkan API key Anda</li>
            <li>Ganti <code>YOUR_NEWSAPI_KEY_HERE</code> di baris 9 file <code>news.php</code> dengan API key Anda</li>
        </ol>
        <p class="mb-0"><small>API key gratis memberikan 100 request/hari - cukup untuk penggunaan pribadi.</small></p>
    </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5><i class="bi bi-currency-bitcoin"></i> Crypto REST Client</h5>
                <p class="mb-0">Platform informasi cryptocurrency terlengkap dan terkini.</p>
            </div>
            <div class="col-md-6 text-end">
                <p class="mb-0">
                    <small>
                        <i class="bi bi-code-slash"></i> Dibangun dengan PHP & Bootstrap |
                        &copy; <?= date('Y') ?> Crypto REST Client
                    </small>
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fungsi untuk reset form
function clearSearch() {
    window.location.href = 'news.php';
}

// Loading spinner saat submit form
document.getElementById('newsForm').addEventListener('submit', function() {
    document.getElementById('loadingSpinner').style.display = 'inline-block';
    document.getElementById('searchBtn').disabled = true;
});

// Auto-focus pada input pencarian
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.focus();
    }
    
    // Submit form dengan Enter
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('newsForm').submit();
            }
        });
    }
    
    // Animasi untuk kartu berita
    const newsCards = document.querySelectorAll('.news-card');
    newsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Bookmark artikel (contoh sederhana)
function bookmarkArticle(title, url) {
    const bookmarks = JSON.parse(localStorage.getItem('cryptoNewsBookmarks') || '[]');
    const newBookmark = { title, url, date: new Date().toISOString() };
    
    // Cek jika sudah ada
    const exists = bookmarks.some(b => b.url === url);
    if (!exists) {
        bookmarks.push(newBookmark);
        localStorage.setItem('cryptoNewsBookmarks', JSON.stringify(bookmarks));
        alert('Artikel berhasil disimpan di bookmark!');
    } else {
        alert('Artikel sudah ada di bookmark!');
    }
}

// Share artikel
function shareArticle(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Baca berita cryptocurrency: ' + title,
            url: url
        });
    } else {
        // Fallback untuk browser lama
        const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}
</script>
</body>
</html>

<?php
// Fungsi untuk data dummy berita (fallback jika API tidak tersedia)
function getDummyNews() {
    return [
        [
            'title' => 'Bitcoin Melonjak di Atas $40,000 Setelah ETF Disetujui',
            'description' => 'Harga Bitcoin mencapai level tertinggi dalam 18 bulan setelah regulator menyetujui beberapa ETF Bitcoin.',
            'url' => 'https://www.coindesk.com/bitcoin-40000-etf-approved',
            'urlToImage' => 'https://images.unsplash.com/photo-1518546305927-5a555bb7020d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinDesk'],
            'author' => 'John Crypto',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-1 day'))
        ],
        [
            'title' => 'Ethereum 2.0: Transisi ke Proof-of-Stake Berjalan Sukses',
            'description' => 'Upgrade besar Ethereum ke Proof-of-Stake mengurangi konsumsi energi hingga 99% dan meningkatkan skalabilitas.',
            'url' => 'https://cointelegraph.com/ethereum-2-0-success',
            'urlToImage' => 'https://images.unsplash.com/photo-1620336655055-bd87c5d1d73f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinTelegraph'],
            'author' => 'Sarah Blockchain',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-2 days'))
        ],
        [
            'title' => 'NFT Marketplace Baru Tumbuh 300% dalam 3 Bulan',
            'description' => 'Platform NFT baru berhasil menarik jutaan pengguna dengan fokus pada seni digital dan koleksi eksklusif.',
            'url' => 'https://cryptonews.com/nft-marketplace-growth',
            'urlToImage' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CryptoNews'],
            'author' => 'Mike Digital',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-3 days'))
        ],
        [
            'title' => 'DeFi Lending Platform Raih Pendanaan $50 Juta',
            'description' => 'Platform pinjaman terdesentralisasi berhasil mengumpulkan dana besar dari investor venture capital terkemuka.',
            'url' => 'https://www.newsbtc.com/defi-lending-funding',
            'urlToImage' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'NewsBTC'],
            'author' => 'Lisa Finance',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-4 days'))
        ],
        [
            'title' => 'Regulasi Cryptocurrency di Asia Tenggara Diperketat',
            'description' => 'Negara-negara ASEAN mulai menerapkan regulasi yang lebih ketat untuk industri cryptocurrency.',
            'url' => 'https://bitcoinist.com/sea-crypto-regulation',
            'urlToImage' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'Bitcoinist'],
            'author' => 'David Regulator',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-5 days'))
        ],
        [
            'title' => 'Solana Melampaui Ethereum dalam Volume Transaksi Harian',
            'description' => 'Untuk pertama kalinya, Solana mencatat volume transaksi harian yang lebih tinggi daripada Ethereum.',
            'url' => 'https://www.coindesk.com/solana-transactions-surpass-ethereum',
            'urlToImage' => 'https://images.unsplash.com/photo-1621570072029-6d3f8eecd4c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinDesk'],
            'author' => 'Robert Tech',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-6 days'))
        ],
        [
            'title' => 'Metaverse Land dijual dengan Harga Rekor $2.5 Juta',
            'description' => 'Sebuah plot tanah virtual di metaverse terjual dengan harga yang mencengangkan, menandai minat yang tinggi.',
            'url' => 'https://cointelegraph.com/metaverse-land-record-sale',
            'urlToImage' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinTelegraph'],
            'author' => 'Emma Virtual',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-1 week'))
        ],
        [
            'title' => 'Bank Sentral Brasil Uji Coba Digital Real',
            'description' => 'Bank sentral Brasil memulai uji coba mata uang digitalnya sendiri dengan fokus pada inklusi keuangan.',
            'url' => 'https://cryptonews.com/brazil-cbdc-test',
            'urlToImage' => 'https://images.unsplash.com/photo-1589666564459-93cdd3c64de6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CryptoNews'],
            'author' => 'Carlos Central',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-8 days'))
        ],
        [
            'title' => 'Ripple vs SEC: Kasus Hukum Masih Berlanjut',
            'description' => 'Perkara hukum antara Ripple dan SEC memasuki babak baru dengan kemungkinan penyelesaian di tahun 2024.',
            'url' => 'https://www.newsbtc.com/ripple-sec-case-update',
            'urlToImage' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'NewsBTC'],
            'author' => 'Legal Expert',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-9 days'))
        ],
        [
            'title' => 'Dogecoin Diadopsi oleh Merchant Online Terbesar',
            'description' => 'Platform e-commerce terbesar di dunia mulai menerima Dogecoin sebagai metode pembayaran.',
            'url' => 'https://bitcoinist.com/dogecoin-adoption-merchant',
            'urlToImage' => 'https://images.unsplash.com/photo-1621570331308-4a300b6b7aa4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'Bitcoinist'],
            'author' => 'Meme Master',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-10 days'))
        ],
        [
            'title' => 'AI dan Blockchain: Kecerdasan Buatan di Web3',
            'description' => 'Integrasi teknologi AI dengan blockchain membuka peluang baru untuk aplikasi terdesentralisasi.',
            'url' => 'https://www.coindesk.com/ai-blockchain-web3',
            'urlToImage' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinDesk'],
            'author' => 'AI Researcher',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-11 days'))
        ],
        [
            'title' => 'Crypto Gaming: In-Game Assets Bernilai Miliaran Dolar',
            'description' => 'Industri game blockchain tumbuh pesat dengan aset dalam game yang bernilai miliaran dolar.',
            'url' => 'https://cointelegraph.com/crypto-gaming-growth',
            'urlToImage' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80',
            'source' => ['name' => 'CoinTelegraph'],
            'author' => 'Game Developer',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-12 days'))
        ]
    ];
}
?>