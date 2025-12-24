# Sistem Manajemen Parkir

Aplikasi web untuk mengelola sistem parkir kendaraan secara terkomputerisasi, mulai dari kendaraan masuk, keluar, hingga pencatatan transaksi parkir.

---

## Deskripsi Project

Sistem Manajemen Parkir adalah aplikasi berbasis web yang dibuat menggunakan PHP dengan struktur MVC.  
Aplikasi ini bertujuan untuk membantu petugas dan admin dalam mengelola data parkir secara lebih rapi, cepat, dan efisien.

Project ini cocok digunakan sebagai:
- Tugas sekolah / UUK
- Project latihan backend PHP
- Dasar sistem parkir sederhana

---

## Struktur Folder

Sistem-Manajemen-Parkir/
├── App/ # Logic aplikasi
├── Config/ # Konfigurasi database & aplikasi
├── Public/ # File publik (CSS, JS, images)
├── Resources/
│ └── Views/ # Tampilan web (UI)
├── Routes/ # Routing aplikasi
├── uploads/ # File upload (gambar / data)
├── composer.json
├── package.json
└── README.md

yaml
Salin kode

---

## Fitur Utama

- Login user dan admin
- Input kendaraan masuk
- Proses kendaraan keluar
- Perhitungan durasi parkir
- Perhitungan biaya parkir
- Data kendaraan terparkir
- Riwayat transaksi parkir
- Upload file pendukung

---

## Teknologi yang Digunakan

| Komponen   | Teknologi |
|-----------|-----------|
| Backend   | PHP |
| Frontend | HTML, CSS, JavaScript |
| Database | MySQL / MariaDB |
| Styling  | Tailwind CSS |
| Server   | Apache / Nginx |

---

## Cara Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Fadlan079/Sistem-Manajemen-Parkir.git
cd Sistem-Manajemen-Parkir
2. Install Dependency PHP
bash
Salin kode
composer install
3. Konfigurasi Database
Buat database baru di MySQL atau MariaDB

Atur koneksi database pada folder Config/

4. Jalankan Server
Jika menggunakan PHP built-in server:

bash
Salin kode
php -S localhost:8000 -t Public/
Atau gunakan web server:

XAMPP

Laragon

Apache dan MySQL

Alur Penggunaan Sistem
Petugas
Login ke sistem

Input kendaraan masuk

Proses kendaraan keluar

Sistem menghitung durasi dan biaya parkir

Admin
Login sebagai admin

Melihat data kendaraan

Mengelola transaksi parkir

Melihat laporan parkir

Lisensi
Project ini menggunakan lisensi MIT.
Bebas digunakan untuk pembelajaran dan pengembangan.

Author
Fadlan
GitHub: https://github.com/Fadlan079