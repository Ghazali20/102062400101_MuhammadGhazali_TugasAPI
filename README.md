# Library Management System (REST API Integration)

Project ini merupakan implementasi sistem manajemen perpustakaan yang menghubungkan dua framework berbeda (**Laravel 11** sebagai API Provider dan **CodeIgniter 4** sebagai API Consumer) melalui arsitektur REST API.

---

## Identitas Mahasiswa
**Nama:** Muhammad Ghazali 
**NIM:** 102062400101 
**Prodi:** S1 Sistem Informasi 
**Instansi:** Telkom University Surabaya 

---

## 🏗️ Arsitektur Project

| Komponen | Framework | Peran | URL Default |
| :--- | :--- | :--- | :--- |
| **Backend** | Laravel 11 API Provider (Penyedia Data)  | `http://localhost:8000`  |
| **Frontend** | CodeIgniter 4 | API Consumer (Pengambil Data)  | `http://localhost:8080` |

---

## 🔧 Konfigurasi & Instalasi

### 1. Persiapan Database
1. Pastikan MySQL (XAMPP) menyala.
2. Buat database baru bernama `library_api`.
3. Masuk ke terminal folder `library-api`, lalu jalankan perintah migrasi dan seeder untuk data sampel (Books & Members)
   ```bash
   php artisan migrate --seed

## 2. Pengaturan Environment (.env)

Pastikan konfigurasi environment pada kedua project sudah saling terhubung agar data dapat mengalir dengan lancar:

**Pada folder `library-api` (Laravel):**
  Sesuaikan konfigurasi database MySQL agar menunjuk ke DB yang telah dibuat.
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=library_api
  DB_USERNAME=root
  DB_PASSWORD=

Pada folder library-app (CodeIgniter 4):
# Mode Pengembangan
CI_ENVIRONMENT = development
# URL Aplikasi CI4
app.baseURL = 'http://localhost:8080/' 
# Endpoint API Backend (Laravel)
LIBRARY_API_URL = http://localhost:8000/api 

**Cara Menjalankan
1.Pastikan Library API (Laravel) sudah berjalan di port 8000.
  php artisan serve
2.Buka terminal di folder library-app.
3.Jalankan perintah:
    php spark serve
4.Akses di browser: http://localhost:8080/books

Komponen Penting Project
1.LibraryService (app/Services/LibraryService.php): Menggunakan library cURL untuk melakukan request GET, PUT, dan DELETE ke Backend Laravel .
2.BookController (app/Controllers/BookController.php): Mengelola logika pengambilan data buku dan mengirimkannya ke View .
3.Routes (app/Config/Routes.php): Mengatur alamat URL untuk fitur Books dan Members.
4.Views (app/Views/books/index.php): Menampilkan tabel data buku secara dinamis .

Fitur yang Diimplementasikan
1.Daftar Buku: Menampilkan data real-time dari API.
2.Hapus Buku: Terintegrasi dengan validasi stok (Gagal jika stok > 0) .
3.Daftar & Hapus Member: Terintegrasi dengan validasi status (Gagal jika status Active)
