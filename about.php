<?php
// about.php

// Tentukan halaman aktif
$page = isset($_GET['page']) ? $_GET['page'] : 'about';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - Crypto REST Client</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
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

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #6f42c1, #0d6efd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 24px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- NAVBAR YANG SAMA DENGAN INDEX -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                        <a class="nav-link active" href="about.php">
                            <i class="bi bi-info-circle"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">
                            <i class="bi bi-envelope"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.php">
                            <i class="bi bi-newspaper"></i> News
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="about-content">
            <h2 class="mb-4 text-center">📋 Tentang Crypto REST Client</h2>

            <!-- Deskripsi Proyek -->
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-info-circle"></i> Deskripsi Proyek</h4>
                </div>
                <div class="card-body">
                    <h5 class="section-title">Apa Itu Crypto REST Client?</h5>
                    <p class="mb-3">
                        <strong>Crypto REST Client</strong> adalah sebuah aplikasi web yang dirancang untuk menampilkan
                        informasi harga cryptocurrency secara real-time. Proyek ini bertujuan untuk memberikan
                        akses mudah dan cepat kepada pengguna yang ingin memantau perkembangan pasar cryptocurrency
                        tanpa perlu mengunjungi platform trading yang kompleks.
                    </p>

                    <h5 class="section-title mt-4">Fitur Utama</h5>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h5>Data Real-time</h5>
                                <p class="text-muted">Update harga cryptocurrency setiap 5 detik</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5>Aman & Terpercaya</h5>
                                <p class="text-muted">Menggunakan API resmi Coinranking</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <h5>Responsif</h5>
                                <p class="text-muted">Akses dari desktop maupun mobile</p>
                            </div>
                        </div>
                    </div>

                    <h5 class="section-title mt-4">Teknologi yang Digunakan</h5>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary">
                                        <i class="bi bi-laptop"></i> Frontend
                                    </h5>
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
                                    <h5 class="card-title text-success">
                                        <i class="bi bi-server"></i> Backend
                                    </h5>
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
                                    <h5 class="card-title text-warning">
                                        <i class="bi bi-plug"></i> API & Services
                                    </h5>
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
                    <h4 class="mb-0"><i class="bi bi-people"></i> Tim Pengembang</h4>
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
            </div>

            <!-- Kontak dan Sumber -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-link-45deg"></i> Informasi Kontak & Sumber</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="section-title">Kontak</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-envelope text-primary"></i> 
                                    <a href="contact.php">Hubungi Kami</a> melalui form kontak
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-github text-dark"></i> 
                                    <a href="https://github.com" target="_blank">GitHub Repository</a>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-building text-secondary"></i> 
                                    Universitas Nusantara PGRI Kediri
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="section-title">Sumber Data</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-database text-success"></i> 
                                    <a href="https://coinranking.com" target="_blank">Coinranking API</a> - Data cryptocurrency
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-newspaper text-info"></i> 
                                    <a href="news.php" target="_blank">Berita Crypto</a> - Update terbaru
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-warning"></i> 
                                    Data diupdate setiap 5 detik
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>