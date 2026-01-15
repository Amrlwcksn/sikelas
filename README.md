# Sikelas - Sistem Keuangan Kelas

Sikelas (Sistem Keuangan Kelas) adalah platform berbasis web yang dirancang untuk memodernisasi pengelolaan dana kas dalam lingkup organisasi kelas atau komunitas mahasiswa. Sistem ini bertujuan untuk menciptakan transparansi, akuntabilitas, dan efisiensi dalam pencatatan transaksi keuangan, menggantikan metode pembukuan manual yang rentan terhadap kesalahan.

Project ini dikembangkan menggunakan framework Laravel untuk backend dan Tailwind CSS untuk antarmuka pengguna, menawarkan pengalaman penggunaan yang responsif, modern, dan aman.

## Fitur Utama

### Untuk Pengurus (Bendahara/Admin)
*   **Dashboard Finansial**: Memantau total dana kas, arus kas masuk/keluar, dan statistik partisipasi mahasiswa dalam satu pandangan.
*   **Manajemen Transaksi**: Mencatat pemasukan (setoran kas) dan pengeluaran dana dengan validasi saldo otomatis.
*   **Laporan Keuangan Otomatis**: Menghasilkan laporan rekapitulasi kas bulanan dengan tampilan matriks harian atau ringkasan periode.
*   **Cetak Dokumen Resmi**: Kemampuan untuk mencetak Laporan Audit Bulanan (FIN-01) dan Sertifikat Validasi Saldo (FIN-02) dengan format standar yang profesional.
*   **Manajemen Anggota**: Mengelola data mahasiswa dan akun keuangan mereka.

### Untuk Mahasiswa
*   **Dashboard Personal**: Melihat saldo tabungan pribadi secara real-time melalui antarmuka Kartu Digital.
*   **Riwayat Transaksi**: Akses penuh terhadap histori setoran dan penarikan yang telah dilakukan.
*   **Transparansi Dana**: Memantau total akumulasi dana kas kelas untuk memastikan keterbukaan informasi.
*   **Informasi Validasi**: Panduan untuk mendapatkan bukti validasi saldo resmi dari pengurus.

## Teknologi yang Digunakan

*   **Backend**: PHP (Laravel Framework)
*   **Frontend**: Blade Templates, Tailwind CSS
*   **Database**: MySQL
*   **Scripting**: JavaScript (Alpine.js / Vanilla JS)

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat Anda telah terinstal:
*   PHP >= 8.1
*   Composer
*   Node.js & NPM
*   MySQL Database

## Panduan Instalasi dan Menjalankan Project

Ikuti langkah-langkah berikut untuk menginstalasikan project ini di lingkungan lokal Anda:

1.  **Duplikasi Repository**
    Salin kode sumber project ke direktori lokal Anda.

2.  **Instalasi Dependensi Backend**
    Buka terminal di direktori project dan jalankan perintah:
    ```bash
    composer install
    ```

3.  **Instalasi Dependensi Frontend**
    Jalankan perintah berikut untuk menginstal paket-paket JavaScript:
    ```bash
    npm install
    ```

4.  **Konfigurasi Lingkungan (Environment)**
    Salin file konfigurasi contoh `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5.  **Generate Application Key**
    Jalankan perintah untuk membuat kunci enkripsi aplikasi:
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database**
    Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
    ```bash
    php artisan migrate
    ```
    *Opsional: Jika tersedia seeder, Anda dapat menjalankannya dengan `php artisan db:seed`.*

7.  **Menjalankan Aplikasi**
    Anda perlu menjalankan dua terminal terpisah untuk menjalankan server backend dan proses build frontend.

    **Terminal 1 (Laravel Server):**
    ```bash
    php artisan serve
    ```

    **Terminal 2 (Vite Development Server):**
    ```bash
    npm run dev
    ```

8.  **Akses Aplikasi**
    Buka browser dan kunjungi alamat yang tertera pada output Terminal 1 (biasanya `http://127.0.0.1:8000`).

## Struktur Laporan

Sistem ini menghasilkan dokumen dengan kode standar untuk kemudahan pengarsipan:
*   **FIN-01.REKAP**: Laporan Rekapitulasi Bukti Kas Kelas (Bulanan).
*   **FIN-02.VLD.SALDO**: Dokumen Validasi Cek Saldo Individu.

## Catatan Pengembang

Pastikan konfigurasi izin (permissions) pada folder `storage` dan `bootstrap/cache` telah diatur agar dapat ditulis (writable) oleh web server untuk menghindari error 500 saat runtime.
