 <?php
// =======================
// CONTACT FORM
// =======================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // (3) Pesan tidak boleh kosong
    $pesan = trim($_POST["pesan"] ?? "");
    if (empty($pesan)) {
        die("Pesan tidak boleh kosong!");
    }

    // Simpan ke file JSON
    $data = [
        "pesan" => $pesan,
        "waktu" => date("Y-m-d H:i:s")
    ];

    file_put_contents("kontak.json", json_encode($data, JSON_PRETTY_PRINT));

    // (4) Valid JSON setelah disimpan
    $cek = json_decode(file_get_contents("kontak.json"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("File tersimpan bukan JSON valid!");
    }

    // (5) Response code 200
    http_response_code(200);

    $berhasil = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">REST Client Coin-Crypto</a>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link text-white" href="berita.php">Berita Crypto</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="index.php">REST Client</a></li>
            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="about.php">About</a></li>
        </ul>
    </div>
</nav>

<div class="container py-5">
    <h3 class="text-center mb-4">📩 Form Kontak</h3>

    <?php if (!empty($berhasil)): ?>
        <div class="alert alert-success text-center">Pesan berhasil disimpan.</div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold">Pesan :</label>
            <textarea name="pesan" class="form-control" rows="5" placeholder="Tulis pesan..." required></textarea>
        </div>

        <button class="btn btn-primary w-100">Kirim Pesan</button>
    </form>
</div>

</body>
</html>
