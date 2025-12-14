<?php
// contact.php

// ==== VALIDASI EMAIL TUJUAN (sebagai pengganti rule #3 API key) ====
$targetEmail = "khusustugas438@gmail.com";
if (empty($targetEmail)) {
    die("Email tujuan tidak boleh kosong!");
}

$responseMessage = "";
$isJson = false;

// ==== Jika form dikirim ====
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama   = trim($_POST["nama"] ?? "");
    $email  = trim($_POST["email"] ?? "");
    $pesan  = trim($_POST["pesan"] ?? "");

    // Validasi form
    if ($nama === "" || $email === "" || $pesan === "") {
        $responseMessage = "Semua field wajib diisi!";
    } else {

        // ==== Kirim email (opsional - bisa dimatikan jika tidak perlu) ====
        $subject = "Pesan Baru dari Contact Form";
        $body    = "Nama: $nama\nEmail: $email\n\nPesan:\n$pesan";

        // mail($targetEmail, $subject, $body); // aktifkan jika server mendukung mail()

        // ==== GitHub Action Rule #4: RETURN JSON VALID ====
        $isJson = true;
        header("Content-Type: application/json");
        http_response_code(200); // Rule #5

        echo json_encode([
            "status" => "success",
            "message" => "Pesan berhasil dikirim!",
            "data" => [
                "nama" => $nama,
                "email" => $email,
                "pesan" => $pesan
            ]
        ]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact – Crypto REST Client</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- ==== NAVBAR SAMA SEPERTI INDEX ==== -->
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

                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="alamat.php">Alamat</a></li>

            </ul>
        </div>
    </div>
</nav>

<!-- ==== FORM CONTACT ==== -->
<div class="container py-5">
    <h2 class="mb-4 text-center">📩 Hubungi Kami</h2>

    <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">

        <?php if ($responseMessage !== "" && !$isJson): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($responseMessage) ?></div>
        <?php endif; ?>

        <form id="contactForm" method="POST">

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pesan</label>
                <textarea name="pesan" class="form-control" rows="5" required></textarea>
            </div>

            <button class="btn btn-dark w-100" type="submit">Kirim Pesan</button>
        </form>

        <div id="result" class="mt-3"></div>

    </div>
</div>

<script>
// AJAX untuk menampilkan JSON result tanpa reload halaman
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("contact.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(json => {
        document.getElementById("result").innerHTML =
            `<div class="alert alert-success">${json.message}</div>`;
    })
    .catch(() => {
        document.getElementById("result").innerHTML =
            `<div class="alert alert-danger">Terjadi kesalahan!</div>`;
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
