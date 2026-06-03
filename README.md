# 🔧 BengkelPro — Sistem Manajemen Bengkel Ketok Magic
<img width="1258" height="842" alt="image" src="https://github.com/user-attachments/assets/24de0ff7-b9ab-4379-8c11-9cb5ce55f9bd" />
<img width="1896" height="930" alt="image" src="https://github.com/user-attachments/assets/832d05f5-a78b-42bc-9a34-c39cb69f5f5e" />
<img width="1901" height="930" alt="image" src="https://github.com/user-attachments/assets/90efb8b7-5da3-4671-aad6-4e89a60ce52a" />

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Sistem manajemen antrian dan pengerjaan berbasis web untuk bengkel spesialis **Ketok Magic**, **Cat**, dan **Ganti Sparepart**. Dibangun dengan Laravel dan Tailwind CSS, mendukung dark mode dan tampilan mobile-friendly.

---

## ✨ Fitur Utama

- **Manajemen Antrian** — tambah, pantau, dan kelola antrian kendaraan secara real-time
- **Auto-assign Mekanik** — sistem round robin otomatis berdasarkan spesialisasi mekanik
- **Halaman Pengerjaan** — estimasi waktu selesai dengan perhitungan jam kerja bengkel (08:00–16:00)
- **Invoice & Laporan** — cetak invoice PDF, export Excel, filter per periode dan spesialisasi
- **Dashboard** — grafik pendapatan 7 hari, statistik antrian, log aktivitas terbaru
- **Dark Mode** — mendukung light dan dark theme
- **Responsive** — tampilan optimal di desktop, tablet, dan HP

---

## 🗂️ Modul

| Modul | Deskripsi |
|---|---|
| Master Data | Kelola layanan service dan data mekanik |
| Data Antrian | Input dan pantau antrian kendaraan |
| Pengerjaan | Monitor unit yang sedang dikerjakan |
| Invoice | Riwayat transaksi dan laporan pendapatan |
| Dashboard | Ringkasan statistik bengkel |

---

## 🚀 Cara Install

### Prasyarat
- PHP >= 8.3
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/BENGKELPRO.git
cd bengkelpro

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node
npm install && npm run build

# 4. Copy file environment
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bengkel_db
DB_USERNAME=root
DB_PASSWORD=

# 7. Jalankan migrasi dan seeder
php artisan migrate --seed

# 8. Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

---

## 🔐 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Email | Password | Keterangan |
|---|---|---|
| `admin@bengkelpro.com` | `password` | Administrator |

> ⚠️ Segera ganti password setelah login pertama kali!

---

## 📸 Screenshot

> Tambahkan screenshot aplikasi di sini

---

## 🛠️ Tech Stack

- **Backend** — Laravel 13, PHP 8.3
- **Frontend** — Tailwind CSS, Alpine.js, Font Awesome
- **Database** — MySQL 8
- **PDF** — Barryvdh DomPDF
- **Excel** — Maatwebsite Excel

---

## 📄 Lisensi

Project ini dibuat untuk keperluan tugas/portofolio. Bebas digunakan dan dimodifikasi.

---

## 👨‍💻 Developer

Dibuat dengan menggunakan Laravel & Tailwind CSS.
