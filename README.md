# Sikelas - Portal Kendali Kelas Terintegrasi

Sikelas adalah platform modern berbasis web yang dirancang khusus untuk memfasilitasi pengelolaan administrasi kelas mahasiswa secara profesional. Mulai dari transparansi tabungan kas, pelacakan tugas akademik, hingga manajemen jadwal perkuliahan, semuanya terpusat dalam satu dashboard.

Sistem ini memastikan akuntabilitas antara Bendahara, Sekertaris, dan Mahasiswa tetap terjaga melalui integrasi data yang aman dan transparan.

---

## Fitur Utama dan Peran

### 1. Untuk Sekertaris (Manajer Akademik)
*   Manajemen Perkuliahan: Input dan kelola jadwal kuliah mingguan dengan tampilan matrix yang rapi.
*   Pusat Penugasan (Official): Mengumumkan tugas yang terhubung langsung dengan mata kuliah pilihan.
*   Monitoring Deadline: Memantau seluruh batas waktu penugasan kelas agar tidak ada yang terlewat.

### 2. Untuk Bendahara (Manajer Keuangan)
*   Pencatatan Masuk dan Keluar: Mencatat setiap setoran dan pengeluaran kas dengan validasi saldo otomatis guna mencegah saldo negatif.
*   Validasi QRIS: Memvalidasi konfirmasi pembayaran dari mahasiswa dengan jejak audit yang jelas.
*   Audit Keuangan: Menghasilkan laporan bulanan profesional (FIN-01/02) yang siap cetak dan tanda tangan.

### 3. Untuk Mahasiswa (User Dashboard)
*   Kartu Digital Finansial: Memantau saldo pribadi dan total kas kelas secara real-time.
*   Pusat Informasi Tugas: Melihat daftar tugas aktif dengan pengingat deadline dalam Bahasa Indonesia.
*   Bayar Kas via QRIS: Pembayaran mudah dengan sistem konfirmasi ganda (2-Layer Security) agar transaksi aman dan akurat.
*   Kalender Jadwal: Pantau jadwal kuliah hari ini dan satu minggu ke depan dengan mudah.

---

## Panduan Instalasi untuk Pengguna Lokal

Project ini sangat mudah dioperasikan di perangkat pribadi menggunakan stack standar seperti XAMPP atau Laragon serta Node.js.

### Langkah 1: Persiapan Dasar
1. Pastikan perangkat Anda sudah terinstal PHP (v8.1 atau lebih baru), Composer, dan Node.js.
2. Buat database baru dengan nama "sikelas" melalui panel PhpMyAdmin Anda.

### Langkah 2: Konfigurasi Project
Buka terminal atau command prompt di dalam folder project ini, kemudian eksekusi perintah berikut secara berurutan:

1. Instalasi Library:
   ```bash
   composer install
   npm install
   ```

2. Setup Environment:
   * Salin file .env.example menjadi .env.
   * Pastikan konfigurasi database pada file .env sudah sesuai (DB_DATABASE=sikelas).
   * Masukkan username dan password database Anda jika diperlukan.

3. Inisialisasi Database (Satu Langkah Instan):
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```
   Eksekusi perintah di atas akan secara otomatis membangun tabel dan mengisi akun demo untuk kebutuhan pengujian.

### Langkah 3: Menjalankan Aplikasi
Buka dua jendela terminal terpisah untuk menjalankan service berikut:

* Terminal 1 (Backend Server):
  ```bash
  php artisan serve
  ```
* Terminal 2 (Frontend Dev Server):
  ```bash
  npm run dev
  ```

Setelah kedua service berjalan, akses aplikasi melalui browser pada alamat: http://127.0.0.1:8000

---

## Akun Uji Coba (Demo)
Anda dapat menggunakan kredensial di bawah ini untuk menguji fitur setelah proses seeding selesai:

| Peran | Alamat Email | Kata Sandi |
| :--- | :--- | :--- |
| Bendahara | bendahara@sikelas.com | password |
| Sekertaris | sekertaris@sikelas.com | password |
| Mahasiswa | student@sikelas.com | password |

---

## Integrasi Keamanan QRIS
Agar fitur pembayaran via QRIS berfungsi dengan benar, pastikan file gambar QR diletakkan pada direktori berikut:
public/qris.jpeg

Jika file tersebut tidak terdeteksi, sistem secara otomatis akan mengaktifkan protokol keamanan dengan menampilkan peringatan dan mengunci tombol pembayaran guna menghindari kesalahan transaksi.

---
Dikembangkan secara profesional untuk mendukung kemajuan manajemen organisasi mahasiswa.
