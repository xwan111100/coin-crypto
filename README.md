# coin-crypto
repository ini menggunakan API Key dari Rest Client Crypto

## Setup API Key

Semua file PHP di project ini membaca API key dari environment variable `COINRANKING_API_KEY` menggunakan `getenv('COINRANKING_API_KEY')`.

- Jika `COINRANKING_API_KEY` sudah diset pada environment yang menjalankan PHP, maka semua skrip (`index.php`, `fetch.php`, dan test PHPUnit) akan otomatis menggunakan nilai tersebut.

Contoh cara men-set sementara di PowerShell (session saat ini):

```powershell
$env:COINRANKING_API_KEY = 'your_api_key_here'
```

Menjalankan unit tests lokal (Windows PowerShell):

```powershell
Set-Location "c:\xampp\htdocs\coin-crypto"
vendor\bin\phpunit.bat tests/FileTypeTest.php
```

Jika Anda menjalankan aplikasi lewat XAMPP/Apache, Anda bisa men-set environment variable secara global di Windows (System Properties → Environment Variables) atau menambahkan `SetEnv` pada konfigurasi VirtualHost/`httpd.conf` (atau `.htaccess` bila server mengizinkan):

```
SetEnv COINRANKING_API_KEY "your_api_key_here"
```

### GitHub Actions / CI

Workflow CI (`.github/workflows/phpunit.yml`) sudah dikonfigurasi untuk membaca secret `COINRANKING_API_KEY` dari GitHub Secrets. Untuk mengaktifkannya:

1. Buka repository di GitHub → Settings → Secrets and variables → Actions → New repository secret
2. Tambahkan secret dengan nama `COINRANKING_API_KEY` dan masukkan value API key Anda.

Setelah itu, workflow akan menyediakan nilai ini ke job dan PHPUnit akan menggunakan key tersebut saat berjalan di CI.

Catatan keamanan:
- Jangan commit API key ke repository. Jika key pernah terekspose (mis. sebelumnya ada di repo), segera rotate/revoke key dari provider dan perbarui secret di GitHub.
